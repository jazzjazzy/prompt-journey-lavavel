<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptHistory extends Model
{
    use HasFactory;

    protected $table = 'prompt_history';

    protected $fillable = [
        'prompt',
        'basic_params',
        'model_params',
        'upscale_params',
        'suffix',
        'images',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
