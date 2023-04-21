<?php

namespace Database\Factories;

use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class OrganizationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organizations::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
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
            'created_by' => Str::random(10).'@gmail.com',
        ];
    }
}
