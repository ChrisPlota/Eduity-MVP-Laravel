<?php

namespace Tests;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;
    protected $token;
    protected $payload;
    protected $orgpayload;

    public function setUp(): void {
        parent::setUp();
        $this->authToken();
        $this->faker = Factory::create();
        $this->payload = [
            'email' => Str::random(10).'@gmail.com',
            'password' => Str::random(6),
            'first_name' => Str::random(10),
            'middle_name' => Str::random(10),
            'last_name' => Str::random(10),
            'prior_last_name' => Str::random(10),
            'prefix' => Str::random(2),
            'suffix' => Str::random(2),
            'birth_date' => date('Y-m-d', strtotime("-25 years")),
            'mother_maiden_name' => Str::random(10),
            'legal_id' => Str::random(5),
            'driver_license' => Str::random(10),
            'visa_type' => Str::random(10),
            'citizenship' => Str::random(2),
            'miltary_status' => Str::random(10),
            'gender' => Str::random(10),
            'ethnicity' => Str::random(10),
            'disability' => true,
            'is_locked' => true,
            'lock_expiration_date' => date('Y-m-d H:i:s'),
            'login_attempts' => rand(10, 30),
            'last_login_attempt' => date('Y-m-d H:i:s'),
            'is_email_confirmed' => (bool)false,
            'email_confirmation_code' => Str::random(10),
            'reset_password_code' => Str::random(10),
            'unlock_code' => Str::random(10),
            'reset_password_code_expiration_date' => date('Y-m-d H:i:s')
        ];
        $this->orgpayload = [
            'owner_id' => 1,
            'name' => Str::random(30),
            'fein' => Str::random(10),
            'state_id' => Str::random(10),
            'form' => Str::random(20),
            'revenue' => rand(10, 1000000),
            'date_founded' => date('Y-m-d'),
            'purpose' => Str::random(250),
            'description' => Str::random(500),
            'trade_name' => Str::random(10),
            'sector' => '11',
            'subsectors' => Str::random(50),
            'parent_org_id' => null,
            'website_url' => 'http://www.'.Str::random(10).'.com',
            'main_phone' => '123-456-7789',
            'main_email' => Str::random(10).'@gmail.com',
            'contact_id' => null,
            'total_employees' => 100,
            'financial_year_ends' => '03',
            'full_time_hours_per_week' => 40,
            'business_hours' => '10:00 - 16:00',
            'created_by' => Str::random(10).'@gmail.com'
        ];
        Artisan::call('migrate:refresh');
    }
    
    public function __get($key) {
        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }

    public function authToken()
    {
      $email = Str::random(10).'@gmail.com';
      $password = Str::random(6);

      $response = $this->json('POST', 'api/users', [
        'email' => $email,
        'password' => $password
      ])->assertStatus(201)
        ->assertJsonStructure([
          "user" => ['email','id']
        ]);

      $response = $this->json('POST', 'api/jwttoken/createapi', [
          'email' => $email,
          'password' => $password
      ])->assertStatus(200)->assertJsonStructure(['token']);

      $this->token = $response['token'];
    }
}
