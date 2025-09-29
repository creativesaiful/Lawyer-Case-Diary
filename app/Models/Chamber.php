<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function cases()
    {
        return $this->hasMany(CaseDiary::class);
    }
    public function dates()
    {
        return $this->hasMany(Date::class);
    }

}