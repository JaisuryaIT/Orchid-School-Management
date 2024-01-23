<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Subjects extends Model
{
    use HasFactory, AsSource;
    protected $fillable = ['subject_name', 'subject_code'];
}
