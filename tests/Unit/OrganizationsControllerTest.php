<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organizations;
use App\Models\Users;

class OrganizationsControllerTests extends TestCase{
    use RefreshDatabase;

    public function testunauthorizedApiCallErrorTriggered(){
      $this->json('get', 'api/organizations')->assertUnauthorized();
    }

    public function testgetAllOrganizationsReturningValidData(){
      Users::factory(1)->create();
      Organizations::factory(10)->create();

      $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/organizations')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
          "organizations" => [
            '*' => [
              "owner_id",
              "name",
              "fein",
              "state_id",
              "form",
              "revenue",
              "date_founded",
              "purpose",
              "description",
              "trade_name",
              "sector",
              "subsectors",
              "parent_org_id",
              "website_url",
              "main_phone",
              "main_email",
              "contact_id",
              "total_employees",
              "financial_year_ends",
              "full_time_hours_per_week",
              "business_hours",
              "created_by",
              "updated_by"
            ]
          ]
        ]);
    }

    public function testgetSingleOrganizationReturningValidData() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $organization = Organizations::create($this->orgpayload);

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/organizations/'.$organization->id)
        ->assertStatus(200)
        ->assertExactJson([
          "organization" => [
            "id" => $organization->id,
            "uuid" => $organization->uuid,
            "owner_id" => $organization->owner_id,
            "name" => $organization->name,
            "fein" => $organization->fein,
            "state_id" => $organization->state_id,
            "form" => $organization->form,
            "revenue" => $organization->revenue,
            "date_founded" => $organization->date_founded,
            "purpose" => $organization->purpose,
            "description" => $organization->description,
            "trade_name" => $organization->trade_name,
            "sector" => $organization->sector,
            "subsectors" => $organization->subsectors,
            "parent_org_id" => $organization->parent_org_id,
            "website_url" => $organization->website_url,
            "main_phone" => $organization->main_phone,
            "main_email" => $organization->main_email,
            "contact_id" => $organization->contact_id,
            "total_employees" => $organization->total_employees,
            "financial_year_ends" => $organization->financial_year_ends,
            "full_time_hours_per_week" => $organization->full_time_hours_per_week,
            "business_hours" => $organization->business_hours,
            "created_by" => $organization->created_by,
            "updated_by" => $organization->updated_by
          ]
        ]);
    }

    public function testInvalidOrganizationGet() {
      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/organizations/0')
        ->assertStatus(404);
    }

    public function testOrganizationCreateValidation() {
      $payload = $this->orgpayload;
      $payload['name'] = ''; //Emptying name for validation.

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('post', 'api/organizations', $payload)
        ->assertJson(["0" => "Validation Error"]);
    }
    
    public function testOrganizationCreation() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $payload = $this->orgpayload;

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('post', 'api/organizations', $payload)
        ->assertStatus(201)
        ->assertJsonStructure([
          "organization" => [
            "owner_id",
            "name",
            "fein",
            "state_id",
            "form",
            "revenue",
            "date_founded",
            "purpose",
            "description",
            "trade_name",
            "sector",
            "subsectors",
            "parent_org_id",
            "website_url",
            "main_phone",
            "main_email",
            "contact_id",
            "total_employees",
            "financial_year_ends",
            "full_time_hours_per_week",
            "business_hours",
            "created_by",
            "updated_by"
          ]
      ]);
    }

    public function testOrganizationUpdateValidation() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $organization = Organizations::create($this->orgpayload);

      $updateData = [
        'name' => ''
      ];

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', 'api/organizations/'.$organization->id, $updateData)
        ->assertJson(["0" => "Validation Error"]);
    }

    public function testOrganizationUpdation() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $organization = Organizations::create($this->orgpayload);

      $updatedName = Str::random(30);
      $this->orgpayload['name'] = $updatedName;

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', 'api/organizations/'.$organization->id, $this->orgpayload)
        ->assertStatus(200)
        ->assertJson([
          "organization" => [
            "name" => $updatedName
          ]
        ]);
    }

    public function testInvalidOrganizationUpdation() {

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', "api/organizations/0", $this->orgpayload)
        ->assertStatus(404);
    }
    
    public function testOrganizationDelete() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $organization = Organizations::create($this->orgpayload);
      $payload = $this->orgpayload;

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('delete', 'api/organizations/'.$organization->id)
        ->assertNoContent();
      $this->assertDatabaseMissing('organizations', $payload);
    }

    public function testInvalidOrganizationDelete() {
      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('delete', "api/organizations/0")
        ->assertStatus(404);
    }

    public function testOwnerOrganizationGetAll() {
      $user = Users::create(Users::factory()->make()->getAttributes());
      $userId = $user->id;
      $this->orgpayload['owner_id'] = $userId;

      $organization = Organizations::create($this->orgpayload);

      $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/organizations/owner/'.$userId)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
          "organizations" => [
            '*' => [
              "owner_id",
              "name",
              "fein",
              "state_id",
              "form",
              "revenue",
              "date_founded",
              "purpose",
              "description",
              "trade_name",
              "sector",
              "subsectors",
              "parent_org_id",
              "website_url",
              "main_phone",
              "main_email",
              "contact_id",
              "total_employees",
              "financial_year_ends",
              "full_time_hours_per_week",
              "business_hours",
              "created_by",
              "updated_by"
            ]
          ]
        ]);
    }
}