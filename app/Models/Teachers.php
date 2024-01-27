<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Teachers extends Model
{
    use HasFactory, AsSource;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'subject_id',
        'joining_date',
        'qualifications',
        'experience',
        'city',
        'state',
        'zip',
        'salary',
        'qualification_degree',
        'employment_status',
        'responsibilities',
        'emergency_contact_name',
        'emergency_contact_phone',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function subject()
    {
        return $this->belongsTo(Subjects::class);
    }
}
