<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suffixes extends Model
{
    use HasFactory;

    protected $table = 'suffixes';

    protected $fillable = [
        'name',
        'suffix',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);

    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'suffix_group', 'suffix_id', 'group_id');
    }
}
