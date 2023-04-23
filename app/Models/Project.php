<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promptHistories()
    {
        return $this->hasMany(PromptHistory::class);
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function suffix()
    {
        return $this->hasMany(Suffixes::class);
    }
}
