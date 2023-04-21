<?php
namespace App\Http\Controllers;

use JWTAuth;
use App\Models\Users;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiTokenController extends Controller
{
    public function create()
    {
        return view('jwttoken.create');
    }

    public function tokenFetch(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Request is validated
        //Create token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Login credentials are invalid.'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token.'], 400);
        }
 	
         //Token created, return with success response and jwt token
         return response()->json(['token' => $token], 200);
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return view('jwttoken.create', ["errors" => $validator->messages()]);
        }

        //Request is validated
        //Create token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return view('jwttoken.create', ["errors" => collect("Login credentials are invalid.")]);
            }
        } catch (JWTException $e) {
    	    return view('jwttoken.create', ["errors" => collect("Could not create token.")]);
        }
 	
 		//Token created, return with success response and jwt token
        return view('jwttoken.create', ["token" => $token]);
    }
 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
}