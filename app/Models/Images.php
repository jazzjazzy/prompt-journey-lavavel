<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Images extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'images';

    protected $fillable = [
        'name',
        'link',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'image_group', 'image_id', 'group_id');
    }
}
