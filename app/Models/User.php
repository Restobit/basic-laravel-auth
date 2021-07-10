<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const VALIDATION_RULES = [
        'name' => ['required'],
        'email' => ['required', 'unique:users'],
        'roles.*' => ['integer'],
        'roles' => ['required', 'array']
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'accepted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }


    public function sendEmailVerificationNotification()
    {
        try{
        $this->notify(new CustomVerifyEmail());
    }
     catch (\Exception  $e){
        $this->delete();
        Session(['msg' => 'Error']);
     }
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        try {
            $this->notify(new CustomResetPassword($token));
        }
        catch(\Exception $e){
            return $e;
        }

    }

    /**
     * @param $role
     * @return bool
     */
    public function CheckRole($role): bool
    {
        $roles = $this->roles()->get()->pluck('name')->toArray();

        return in_array($role, $roles, true);
    }

    /***
     * @return string
     */
    public function getRolesString(): string
    {
        $roleStr = "";
        foreach ($this->roles as $role) {
            $roleStr .= __('roles.' . $role->id) . ", ";
        }
        return $roleStr;
    }
}
