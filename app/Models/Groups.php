<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;

class Groups extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'groups';
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Images::class, 'image_group', 'image_id', 'group_id');
    }
}
