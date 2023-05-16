<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscriptionItem extends Model
{
    use HasFactory;

    const TABLE = 'subscription_items';
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at',
    ];
}
