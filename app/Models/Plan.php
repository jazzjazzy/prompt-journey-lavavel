<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\PriceCast;


class Plan extends Model
{
    use HasFactory;

    const TABLE = 'plans';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'slug',
        'stripe_name',
        'stripe_id',
        'price',
        'abbreviation',
        'description',
        'metaData'
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
