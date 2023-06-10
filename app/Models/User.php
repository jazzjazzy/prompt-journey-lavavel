<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Position;
use Location;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * @var array
     */
    public $accessLevels= [];
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
        'accessLevels'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

        // Enable the query log
        DB::connection()->enableQueryLog();

        $queryBuilder = Subscription::query()
            ->where('stripe_status', 'active')
            ->where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at');
            });

        $subscriptions = $queryBuilder->first();

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

    public function getPlanFromUserGracePeriod(): ?Plan
    {
        $user = auth()->user();

        $plan = DB::table('subscriptions')
            ->select('plans.*')
            ->join('plans', 'subscriptions.stripe_price', '=', 'plans.stripe_id')
            ->where('stripe_status', 'canceled')
            ->where('ends_at', '>', now())
            ->where('user_id', $user->id)
            ->latest('subscriptions.created_at')
            ->first();
        return $plan ? Plan::hydrate([(array) $plan])->first()  : null;
    }
    /**
     * @return Plan|null
     */
    public function getPlanFromUserSubscription(): ?Plan
    {
        $user = auth()->user();

        $plan = DB::table('subscriptions')
            ->select('plans.*')
            ->join('plans', 'subscriptions.stripe_price', '=', 'plans.stripe_id')
            ->where('stripe_status', 'active')
            ->where('user_id', $user->id)
            ->latest('subscriptions.created_at')
            ->first();

        return $plan ? Plan::hydrate([(array) $plan])->first()  : null;
    }

    public function getUsersPlan(): string
    {
        $plan = $this->getPlanFromUserSubscription();

        if (!$plan) {
            return 'Free';
        }

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

    /**
     * @return $this
     */
    public function getAccessLevels()
    {
        $user = auth()->user();
        $usersPlan = $this->getUsersPlan();

        if($usersPlan === 'Tester' && !$user->subscription('Tester Plan')->onTrial()) {
            $usersPlan = 'Free';
        }

        $accesslevel = new \stdClass();
        $accesslevel->plan = $usersPlan;
        switch ($usersPlan) {
            case 'Tester':
                $accesslevel->suffix = false;
                $accesslevel->images = false;
                $accesslevel->history = true;
                $accesslevel->projectLimit = 1;
                break;
            case 'User':
                $accesslevel->suffix = false;
                $accesslevel->images = false;
                $accesslevel->history = true;
                $accesslevel->projectLimit = 10;
                break;
            case 'Professional':
                $accesslevel->suffix = true;
                $accesslevel->images = true;
                $accesslevel->history = true;
                $accesslevel->projectLimit = 0; //<-- unlimited
                break;
            default:
                $accesslevel->plan = 'Free';
                $accesslevel->suffix = false;
                $accesslevel->images = false;
                $accesslevel->history = false;
                $accesslevel->projectLimit = null;//<-- none
                break;
        }
        return $accesslevel;
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function getUserCountry(Request $request)
    {
        $ip = $request->ip(); // Get the user's IP address

        // since we are in docker we need to set the ip to a mock external AU one
        if(env('APP_ENV') == 'local') {
            $ip = '60.242.236.239';
        }

        $countryInfo = Location::get($ip);

        if($countryInfo instanceof Position){
            return $countryInfo->countryCode;
        }

        return null;
    }
}
