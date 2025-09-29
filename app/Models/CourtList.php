<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtList extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function cases()
    {
        return $this->hasMany(CaseDiary::class, 'court_id');
    }
}