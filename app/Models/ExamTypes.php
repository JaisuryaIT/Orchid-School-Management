<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ExamTypes extends Model
{
    use HasFactory, AsSource;
    protected $fillable = ['exam_type_name','exam_type_code','total_mark','pass_mark'];
}
