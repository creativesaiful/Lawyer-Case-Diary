<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table = 'dates';
    protected $casts = [
    'next_date' => 'datetime',
];
    protected $fillable = ['case_id', 'next_date', 'chamber_id'];
    public function caseDiary()
    {
        return $this->belongsTo(CaseDiary::class, 'case_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
}
