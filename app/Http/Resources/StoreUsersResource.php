<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="StoreUsersResource",
 *     description="Create/Update Users resource",
 *     @OA\Xml(
 *         name="StoreUsers"
 *     ),
 *     @OA\Property(property="email", type="string", example="user1@mail.com"),
 *     @OA\Property(property="password", type="string", example="123456"),
 *     @OA\Property(property="first_name", type="string", example="User"),
 *     @OA\Property(property="middle_name", type="string", example="One"),
 *     @OA\Property(property="last_name", type="string", example="Test"),
 *     @OA\Property(property="prior_last_name", type="string", example="Name"),
 *     @OA\Property(property="prefix", type="string", example="Mr."),
 *     @OA\Property(property="suffix", type="string", example="Suffix"),
 *     @OA\Property(property="birth_date", type="date", example="2000-10-01"),
 *     @OA\Property(property="mother_maiden_name", type="string", example="Mother Name"),
 *     @OA\Property(property="legal_id", type="string", example="XXX"),
 *     @OA\Property(property="driver_license", type="string", example="DL03478797"),
 *     @OA\Property(property="visa_type", type="string", example="Type"),
 *     @OA\Property(property="citizenship", type="string", example="US", minLength=2, maxLength=2),
 *     @OA\Property(property="miltary_status", type="string", example="String"),
 *     @OA\Property(property="gender", type="string", example="String"),
 *     @OA\Property(property="ethnicity", type="string", example="Type"),
 *     @OA\Property(property="disability", type="boolean", example="true"),
 *     @OA\Property(property="is_locked", type="boolean", example="false"),
 *     @OA\Property(property="lock_expiration_date",format="date-time", example="2019-02-25 12:59:20"),
 *     @OA\Property(property="login_attempts", type="integer", example="5"),
 *     @OA\Property(property="last_login_attempt",format="date-time", example="2019-02-25 12:59:20"),
 *     @OA\Property(property="is_email_confirmed", type="boolean", example="false"),
 *     @OA\Property(property="email_confirmation_code", type="string", example="string"),
 *     @OA\Property(property="reset_password_code", type="string", example="string"),
 *     @OA\Property(property="unlock_code", type="string", example="string"),
 *     @OA\Property(property="reset_password_code_expiration_date",format="date-time", example="2019-02-25 12:59:20")
 * )
 */
class StoreUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
