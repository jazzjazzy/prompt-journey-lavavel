<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\PriceCast;


class Plan extends Model
{
    /**
     *
     */
    use HasFactory;

    const TABLE = 'plans';
    /**
     * @var string
     */
    protected $table = self::TABLE;
    /**
     * @var string[]
     */
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

    /**
     * @var string[]
     */
    protected $casts = [
        'price' => PriceCast::class,
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
