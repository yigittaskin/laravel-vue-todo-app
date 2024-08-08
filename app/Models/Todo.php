<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // Toplu atama için izin verilen alanlar
    protected $fillable = ['title', 'completed'];
}
