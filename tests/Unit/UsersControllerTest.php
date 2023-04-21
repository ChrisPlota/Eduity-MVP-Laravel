<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Users;


class UsersControllerTests extends TestCase{
    use RefreshDatabase;    

    public function testunauthorizedApiCallErrorTriggered(){
      $this->json('get', 'api/users')->assertUnauthorized();
    }

    public function testgetAllUsersReturningValidData(){
      Users::factory(5)->create();
      
      $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/users')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
          "users" => [
            '*' => [
              "id",
              "email",
              "first_name",
              "middle_name",
              "last_name",
              "prior_last_name",
              "prefix",
              "suffix",
              "birth_date",
              "mother_maiden_name",
              "legal_id",
              "driver_license",
              "visa_type",
              "citizenship",
              "miltary_status",
              "gender",
              "ethnicity",
              "disability",
              "is_locked",
              "lock_expiration_date",
              "login_attempts",
              "last_login_attempt",
              "is_email_confirmed",
              "created_by",
              "updated_by",
              "created_at",
              "updated_at"
            ]
          ]
        ]);
    }

    public function testgetSingleUserReturningValidData() {      
      $user = Users::create($this->payload);

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/users/'.$user->id)
        ->assertStatus(200)
        ->assertExactJson([
          "user" => [
            "id" => $user->id,
            "uuid" => $user->uuid,
            "email" => $user->email,
            "first_name" => $user->first_name,
            "middle_name" => $user->middle_name,
            "last_name" => $user->last_name,
            "prior_last_name" => $user->prior_last_name,
            "prefix" => $user->prefix,
            "suffix" => $user->suffix,
            "birth_date" => $user->birth_date,
            "mother_maiden_name" => $user->mother_maiden_name,
            "legal_id" => $user->legal_id,
            "driver_license" => $user->driver_license,
            "visa_type" => $user->visa_type,
            "citizenship" => $user->citizenship,
            "miltary_status" => $user->miltary_status,
            "gender" => $user->gender,
            "ethnicity" => $user->ethnicity,
            "disability" => $user->disability,
            "is_locked" => $user->is_locked,
            "lock_expiration_date" => $user->lock_expiration_date,
            "login_attempts" => $user->login_attempts,
            "last_login_attempt" => $user->last_login_attempt,
            "is_email_confirmed" => $user->is_email_confirmed,
            "created_by" => $user->created_by,
            "updated_by" => $user->updated_by,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at
          ]
      ]);
    }

    public function testInvalidUserGet() {
      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('get', 'api/users/0')
        ->assertStatus(404);
    }

    public function testUserCreateValidation() {
      $payload = $this->payload;
      $payload['password'] = ''; //Emptying password for validation.

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('post', 'api/users', $payload)
        ->assertJson(["0" => "Validation Error"]);
    }
    public function testUserCreation() {
      $payload = $this->payload;      
      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('post', 'api/users', $payload)
        ->assertStatus(201)
        ->assertJsonStructure([
          "user" => [
            "id",
            "email",
            "first_name",
            "middle_name",
            "last_name",
            "prior_last_name",
            "prefix",
            "suffix",
            "birth_date",
            "mother_maiden_name",
            "legal_id",
            "driver_license",
            "visa_type",
            "citizenship",
            "miltary_status",
            "gender",
            "ethnicity",
            "disability",
            "is_locked",
            "lock_expiration_date",
            "login_attempts",
            "last_login_attempt",
            "is_email_confirmed",
            "created_by",
            "updated_by",
            "created_at",
            "updated_at"
          ]
      ]);
    }

    public function testUserUpdateValidation() {
      $payload = [
        'email' => Str::random(10).'@gmail.com',
        'password' => Str::random(10)
      ];
      $user = Users::create($payload);

      $updateData = [
        'email' => ''
      ];

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', 'api/users/'.$user->id, $updateData)
        ->assertJson(["0" => "Validation Error"]);
    }

    public function testUserUpdation() {
      $payload = $this->payload;
      $user = Users::create($payload);

      $updateData = [
        'email' => Str::random(10).'@gmail.com',
        'password' => Str::random(6),
        'first_name' => Str::random(10),
        'middle_name' => Str::random(10),
        'last_name' => Str::random(10)       
      ];

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', "api/users/$user->id", $updateData)
        ->assertStatus(200)
        ->assertJson([
          "user" => [
            "email" => $updateData['email'],
            "first_name" => $updateData['first_name'],
            "middle_name" => $updateData['middle_name'],
            "last_name" => $updateData['last_name']
          ]
        ]);
    }

    public function testInvalidUserUpdation() {
      $updateData = [
        'email' => Str::random(10).'@gmail.com',
        'password' => Str::random(6),
        'first_name' => Str::random(10),
        'middle_name' => Str::random(10),
        'last_name' => Str::random(10)       
      ];

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('patch', "api/users/0", $updateData)
        ->assertStatus(404);
    }
    
    public function testUserDelete() {
      $payload = $this->payload;
      $user = Users::create($payload);

      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('delete', 'api/users/'.$user->id)
        ->assertNoContent();
      $this->assertDatabaseMissing('users', $payload);
    }

    public function testInvalidUserDelete() {
      $resp = $this->withHeaders(['Authorization' => "Bearer $this->token"])
        ->json('delete', "api/users/0")
        ->assertStatus(404);
    }
}