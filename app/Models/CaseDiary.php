<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDiary extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'next_date' => 'date',
    ];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function comments()
    {
        return $this->hasMany(CaseComment::class, 'case_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'case_id');
    }

    public function court()
    {
        return $this->belongsTo(CourtList::class);
    }

    public function dates()
    {
        return $this->hasMany(Date::class, 'case_id');
    }
}