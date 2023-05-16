<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suffixes extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'suffixes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'suffix',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'suffix_group', 'suffix_id', 'group_id');
    }
}
