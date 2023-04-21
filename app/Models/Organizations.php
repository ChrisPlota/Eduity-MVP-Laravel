<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Organizations extends Model
{
    use Uuids;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['owner_id', 'uuid', 'name', 'fein', 'state_id', 'form', 'revenue', 'date_founded', 
    'purpose', 'description', 'trade_name', 'sector', 'subsectors', 'parent_org_id', 'website_url', 
    'main_phone', 'main_email', 'contact_id', 'total_employees', 'financial_year_ends', 'full_time_hours_per_week',
    'business_hours', 'created_by', 'updated_by'];

    protected $casts = [
        'full_time_hours_per_week' => 'integer',
        'revenue' => 'integer',
        'total_employees' => 'integer',
        'owner_id' => 'integer',
        'contact_id' => 'integer',
        'parent_org_id' => 'integer'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public static function rules ($id=0, $merge=[]) {
        $websiteRegex = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
        return array_merge(
            [
                // 'administrator'     => 'required',
                'name' => 'required',
                'form' => [
                    'nullable'
                ],
                'description' => 'nullable|min:10|max:1000',
                'total_employees' => 'nullable|gte:0',
                'full_time_hours_per_week' => 'nullable|min:0|max:120',
                'main_email' => 'nullable|email',
                'main_phone' => 'nullable|regex:/^[\(]?[\+]?[1-9]{0,1}[0-9]{0,2}[\)]?[\-\s]?[\(]?[0-9]{3,4}[\)]?[\-\s]?[0-9]{3}[\-\s]?[0-9]{4}$/',
                'website_url' => ['nullable', 'regex:'.$websiteRegex],
                'date_founded' => 'nullable|date'
            ], $merge);
    }

    public static function messages () {
        return array(
            'main_phone' => array('regex', 'Invalid phone number'),
            'website_url' => array('regex', 'Invalid Website URL')
        );
    }
}
