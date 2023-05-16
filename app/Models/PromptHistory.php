<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptHistory extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'suffix' => 'json',
        'images' => 'json',
    ];

    /**
     * @var string
     */
    protected $table = 'prompt_history';

    /**
     * @var string[]
     */
    protected $fillable = [
        'prompt',
        'basic_params',
        'model_params',
        'upscale_params',
        'suffix',
        'images',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
