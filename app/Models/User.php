<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;


    const PLAN_FREE = 1;
    const PLAN_TESTER = 2;
    const PLAN_USER_MONTHLY = 3;
    const PLAN_USER_YEARLY = 5;
    const PLAN_PRO_MONTHLY = 4;
    const PLAN_PRO_YEARLY = 6;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return (bool)$this->subscribedLastActivePlan();
    }

    /**
     * @return Plan|null
     */
    public function subscribedLastActivePlan(): ?Plan
    {
        $plans = Plan::all();
        $user = auth()->user();
        $subscriptions = $this->subscriptions
            ->where('stripe_status', 'active')
            ->where('user_id', $user->id)
            ->where('ends_at', null)
            ->last();

        $currentPlan = null;
        if ($subscriptions) {
            foreach ($plans as $plan) {
                if ($plan->stripe_id == $subscriptions->stripe_price) {
                    $currentPlan = $plan;
                }
            }
        }
        return $currentPlan;
    }

    public function getSubscriptionPlan(): ?Plan
    {
        $plans = Plan::all();
        $user = auth()->user();
        $subscriptions = $this->subscriptions
            ->where('user_id', $user->id)
            ->last();

        $currentPlan = null;
        if ($subscriptions) {
            foreach ($plans as $plan) {
                if ($plan->stripe_id == $subscriptions->stripe_price) {
                    $currentPlan = $plan;
                }
            }
        }
        return $currentPlan;
    }

    public function getUsersPlan()
    {
        $plan = $this->getSubscriptionPlan();
        switch ($plan->id) {
            case self::PLAN_TESTER:
                return 'Tester';
            case self::PLAN_USER_MONTHLY:
            case self::PLAN_USER_YEARLY:
                return 'User';
            case self::PLAN_PRO_MONTHLY:
            case self::PLAN_PRO_YEARLY:
                return 'Professional';
            default:
                return 'Free';
        }
    }
}
