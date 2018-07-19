<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const SEX_MALE = 1;
    const SEX_FEMALE = 0;
    const ROLE_MANAGER =1;
    const ROLE_EMPLOYEE = 0;
    /**
     * Get list gender
     * 
     * @return array
     */
    public static function getGenders()
    {
        return [ 
            self::SEX_MALE => 'Male',
            self::SEX_FEMALE => 'Female',
        ];
    }
    public static function getRoles()
    {
        return[
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_EMPLOYEE => 'Employee',            
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar', 'gender',
         'birthday','code', 'division_id', 'active', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Create random password
     * 
     * @param int $length
     * @return string
     */
    public function createRandomPass($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }
    
    
    public function getById($id)
    {
        return $this->whereNull('is_admin')->findOrFail($id);
    }
}
