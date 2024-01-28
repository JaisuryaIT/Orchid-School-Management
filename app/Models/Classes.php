<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Classes extends Model
{
    use HasFactory,AsSource;
    protected $fillable = [
        'class_name',
        'grade_level',
        'section',
        'teacher_id',
        'academic_year_id',
        'total_students',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teachers::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
