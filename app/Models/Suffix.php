<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suffix extends Model
{
    use HasFactory;

    protected $table = 'prompt_history';

    protected $fillable = [
        'name',
        'suffix',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
