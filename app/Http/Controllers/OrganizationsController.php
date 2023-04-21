<?php

namespace App\Http\Controllers;

//use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Organizations;
use Illuminate\Http\Request;
use App\Http\Resources\OrganizationsResource;
use App\Http\Resources\StoreOrganizationsResource;
use Illuminate\Support\Facades\Validator;

class OrganizationsController extends Controller
{
    //protected $user;
 
    public function __construct()
    {
        //$this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * @OA\Get(
     *      path="/organizations",
     *      operationId="getOrganizationsList",
     *      tags={"Organizations"},
     *      summary="Get list of organizations",
     *      description="Returns list of organizations",
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
     *          description="List of Organizations",
     *          @OA\JsonContent(
     *              @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/OrganizationsResource"))
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
        // Temporarily getting all instead of just 5.
        $organizations = Organizations::all();
        // $organizations = Organizations::paginate(5);
        return response([ 'organizations' => OrganizationsResource::collection($organizations)], 200);
    }

    /**
     * @OA\Post(
     *      path="/organizations",
     *      operationId="createOrganization",
     *      tags={"Organizations"},
     *      summary="Create new organization",
     *      description="Returns created organization information",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreOrganizationsResource")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created Organization detail",
     *          @OA\JsonContent(
     *              @OA\Property(property="organization", type="object", ref="#/components/schemas/OrganizationsResource"),
     *              @OA\Property(property="message", type="string", example="Organization created successfully")
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

        $validator = Validator::make($data, Organizations::rules(), Organizations::messages());
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }
        
        $organization = new Organizations;
        $organization->owner_id = $request->input('owner_id');
        $organization->name = $request->input('name');
        $organization->fein = $request->input('fein');
        $organization->state_id = $request->input('state_id');
        $organization->form = $request->input('form');
        $organization->revenue = $request->input('revenue');
        $organization->date_founded = $request->input('date_founded');
        $organization->purpose = $request->input('purpose');
        $organization->description = $request->input('description');
        $organization->trade_name = $request->input('trade_name');
        $organization->sector = $request->input('sector');
        $organization->subsectors = $request->input('subsectors');
        $organization->parent_org_id = $request->input('parent_org_id');
        $organization->website_url = $request->input('website_url');
        $organization->main_phone = $request->input('main_phone');
        $organization->main_email = $request->input('main_email');
        $organization->contact_id = $request->input('contact_id');
        $organization->total_employees = $request->input('total_employees');
        $organization->financial_year_ends = $request->input('financial_year_ends');
        $organization->full_time_hours_per_week = $request->input('full_time_hours_per_week');
        $organization->business_hours = $request->input('business_hours');
        $organization->save();

        // $organization = Organizations::create($data);
        return response(['organization' => new OrganizationsResource($organization), 'message' => 'Organization created successfully'], 201);
    }

    /**
     * @OA\Get(
     *      path="/organizations/{id}",
     *      operationId="getOrganizationsById",
     *      tags={"Organizations"},
     *      summary="Get organization information",
     *      description="Returns organization details",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Organization id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Organization information",
     *          @OA\JsonContent(
     *              @OA\Property(property="organization", type="object", ref="#/components/schemas/OrganizationsResource")
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
     * @param  \App\Models\Organizations  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organizations $organization)
    {
        return response(['organization' => new OrganizationsResource($organization)], 200);
    }

    /**
     * @OA\Patch(
     *      path="/organizations/{id}",
     *      operationId="updateOrganization",
     *      tags={"Organizations"},
     *      summary="Update existing organization",
     *      description="Returns updated organization information",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Organization id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreOrganizationsResource")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated Organization detail",
     *          @OA\JsonContent(
     *              @OA\Property(property="organization", type="object", ref="#/components/schemas/OrganizationsResource"),
     *              @OA\Property(property="message", type="string", example="Organization updated successfully")
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
     * @param  \App\Models\Organizations  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizations $organization)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, Organizations::rules(), Organizations::messages());
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 400);
        }
        
        $organization->owner_id = $request->input('owner_id');
        $organization->name = $request->input('name');
        $organization->fein = $request->input('fein');
        $organization->state_id = $request->input('state_id');
        $organization->form = $request->input('form');
        $organization->revenue = $request->input('revenue');
        $organization->date_founded = $request->input('date_founded');
        $organization->purpose = $request->input('purpose');
        $organization->description = $request->input('description');
        $organization->trade_name = $request->input('trade_name');
        $organization->sector = $request->input('sector');
        $organization->subsectors = $request->input('subsectors');
        $organization->parent_org_id = $request->input('parent_org_id');
        $organization->website_url = $request->input('website_url');
        $organization->main_phone = $request->input('main_phone');
        $organization->main_email = $request->input('main_email');
        $organization->contact_id = $request->input('contact_id');
        $organization->total_employees = $request->input('total_employees');
        $organization->financial_year_ends = $request->input('financial_year_ends');
        $organization->full_time_hours_per_week = $request->input('full_time_hours_per_week');
        $organization->business_hours = $request->input('business_hours');
        $organization->update($data);
        return response(['organization' => new OrganizationsResource($organization), 'message' => 'Organization updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *      path="/organizations/{id}",
     *      operationId="deleteOrganization",
     *      tags={"Organizations"},
     *      summary="Delete organization",
     *      description="Deletes an organization",
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Organization id",
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
     * @param  \App\Models\Organizations  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizations $organization)
    {
        $organization->delete();

        return response([], 204);
    }

    /**
     * @OA\Get(
     *      path="/organizations/owner/{id}",
     *      operationId="getOwnerOrganizationsList",
     *      tags={"Organizations"},
     *      summary="Get list of owner's organizations",
     *      description="Returns list of owner's organizations",
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
     *      @OA\Parameter(
     *          name="id",
     *          description="Owner id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of Organizations",
     *          @OA\JsonContent(
     *              @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/OrganizationsResource"))
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
    public function owner(Request $request, $id)
    {
        $organizations = Organizations::where('owner_id', $id)->paginate(5);
        return response([ 'organizations' => OrganizationsResource::collection($organizations)], 200);
    }
}