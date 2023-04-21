<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable implements JWTSubject
{
    use Uuids;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'first_name', 'middle_name', 'last_name', 'prior_last_name',
'prefix', 'suffix', 'birth_date', 'mother_maiden_name', 'legal_id', 'driver_license', 'visa_type', 'citizenship', 'miltary_status', 'gender',
'ethnicity', 'disability', 'is_locked', 'lock_expiration_date', 'login_attempts', 'last_login_attempt', 'is_email_confirmed',
'created_by', 'updated_by'];

    protected $casts = [
        'disability' => 'boolean',
        'is_locked' => 'boolean',
        'is_email_confirmed' => 'boolean',
        'login_attempts' => 'integer'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'email_confirmation_code', 'reset_password_code', 'unlock_code',
'reset_password_code_expiration_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public static function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'email'     => ['required','email', 'unique:users'.($id > 0 ? (',email,'.$id) : '')],
                'password' => 'required'
            ], $merge);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
