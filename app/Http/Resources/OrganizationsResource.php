<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="OrganizationsResource",
 *     description="Organization resource",
 *     @OA\Xml(
 *         name="Organizations"
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
class OrganizationsResource extends JsonResource
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
            "uuid" => $this->uuid,
            "owner_id" => $this->owner_id,
            "name" => $this->name,
            "fein" => $this->fein,
            "state_id" => $this->state_id,
            "form" => $this->form,
            "revenue" => $this->revenue,
            "date_founded" => $this->date_founded,
            "purpose" => $this->purpose,
            "description" => $this->description,
            "trade_name" => $this->trade_name,
            "sector" => $this->sector,
            "subsectors" => $this->subsectors,
            "parent_org_id" => $this->parent_org_id,
            "website_url" => $this->website_url,
            "main_phone" => $this->main_phone,
            "main_email" => $this->main_email,
            "contact_id" => $this->contact_id,
            "total_employees" => $this->total_employees,
            "financial_year_ends" => $this->financial_year_ends,
            "full_time_hours_per_week" => $this->full_time_hours_per_week,
            "business_hours" => $this->business_hours,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
        ];
    }
}
