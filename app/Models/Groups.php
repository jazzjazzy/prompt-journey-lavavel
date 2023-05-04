<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;

class Groups extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];

    public function images()
    {
        return $this->belongsToMany(Images::class, 'image_group', 'image_id', 'group_id');
    }
}
