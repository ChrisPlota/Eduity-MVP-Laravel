<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="StoreOrganizationsResource",
 *     description="Create/Update Organization resource",
 *     @OA\Xml(
 *         name="StoreOrganizations"
 *     ),
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="uuid", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="owner_id", type="integer", example="2"),
 *     @OA\Property(property="name", type="string", example="Sample Organization"),
 *     @OA\Property(property="fein", type="string", example="12-3456789"),
 *     @OA\Property(property="state_id", type="string", example="0000-000 0"),
 *     @OA\Property(property="form", type="string", description="Value Choices: 'Sole Proprietor', 'Partnership (General, LP, LLP, or PLLP)', 'Limited Liability Company', 'Corporation (C, S, or professional)', 'Government agency'"),
 *     @OA\Property(property="revenue", type="integer", example="20000"),
 *     @OA\Property(property="date_founded", type="date", example="2000-10-01"),
 *     @OA\Property(property="purpose", type="text", example="The purpose of this company is..."),
 *     @OA\Property(property="description", type="text", example="The description of this company is..."),
 *     @OA\Property(property="trade_name", type="text", example="This company's trade name is..."),
 *     @OA\Property(property="sector", type="string", example="11"),
 *     @OA\Property(property="subsectors", type="text", example="111120, 111130, 111140..."),
 *     @OA\Property(property="parent_org_id", type="integer", example="3"),
 *     @OA\Property(property="website_url", type="string", description="Website URL of an organization", example="http://test.com"),
 *     @OA\Property(property="main_phone", type="string", description="Valid Phone Number", example="343-434-4769"),
 *     @OA\Property(property="main_email", type="string", format="email", description="Email address of organization", example="test@gmail.com"),
 *     @OA\Property(property="contact_id", type="integer", description="User/Owner ID of the organization", example="1"),
 *     @OA\Property(property="total_employees", type="integer", example="50"),
 *     @OA\Property(property="financial_year_ends", type="string", example="06"),
 *     @OA\Property(property="full_time_hours_per_week", type="integer", example="10"),
 *     @OA\Property(property="business_hours", type="string", example="10:00 - 16:00"),
 *     @OA\Property(property="created_by", type="string", example="example@test.com"),
 *     @OA\Property(property="updated_by", type="string", example="example@test.com"),
 * )
 */
class StoreOrganizationsResource extends JsonResource
{
    /**
     * 
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "entityType" => $this->company_type,
            "missionStatement" => $this->mission_statement,
            "valueProposition" => $this->value_proposition,
            "websiteURL" => $this->website_url,
            "mainPhone" => $this->main_phone,
            "mainEmail" => $this->main_email,
            "naicsMajor" => $this->industry_sector,
            "naicsMinor" => $this->industry_subsector,
            "administrator" => $this->owner_id,
            "totalEmployees" => $this->total_employees,
            "annualRevenue" => $this->annual_revenue,
            "financialYearEnds" => $this->financial_year_ends,
            "fullTimeHoursPerWeek" => $this->full_time_per_week,
            "businessHours" => $this->business_hours,
            "dateFounded" => $this->date_founded
        ];
    }
}