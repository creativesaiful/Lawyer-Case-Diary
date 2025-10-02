<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mobile',
        'password',
        'role',
        'chamber_id',
        'bar_number',
        'approved',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function cases()
    {
        return $this->hasMany(CaseDiary::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(CaseComment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function dates()
    {
        return $this->hasMany(Date::class);
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLawyer()
    {
        return $this->role === 'lawyer';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }


}