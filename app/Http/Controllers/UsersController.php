<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="page",
     *          description="Page Number",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=1
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of Users",
     *          @OA\JsonContent(
     *              @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/UsersResource"))
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Users::paginate(5);
        return response([ 'users' => UsersResource::collection($users)], 200);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Create new user",
     *      description="Returns created user information",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUsersResource")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created User detail",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UsersResource"),
     *              @OA\Property(property="message", type="string", example="User created successfully")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, Users::rules());
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        if($request->password != '')
            $data['password'] = Hash::make($request->password);
        
        $user = Users::create($data);
        return response(['user' => new UsersResource($user), 'message' => 'User created successfully'], 201);
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUsersById",
     *      tags={"Users"},
     *      summary="Get user information",
     *      description="Returns user details",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User information",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UsersResource")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * Display the specified resource.
     *
     * @param  \App\Models\Users  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Users $user)
    {
        return response(['user' => new UsersResource($user)], 200);
    }

    /**
     * @OA\Patch(
     *      path="/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing user",
     *      description="Returns updated user information",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUsersResource")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated User detail",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UsersResource"),
     *              @OA\Property(property="message", type="string", example="User updated successfully")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $user)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, Users::rules($user->id));
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        if($request->password != '')
            $data['password'] = Hash::make($request->password);
        
        $user->update($data);
        return response(['user' => new UsersResource($user), 'message' => 'User updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete user",
     *      description="Deletes the user",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful deletion"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $user)
    {
        $user->delete();

        return response([], 204);
    }
}
