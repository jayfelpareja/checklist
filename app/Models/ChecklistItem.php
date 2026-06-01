<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    // Add this line to allow these columns to be saved safely
    protected $fillable = [
        'project_url',
        'category',
        'task',
        'completed',
    ];
}