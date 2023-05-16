<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;


class removeTesterAccountexpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testerExpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command find all expired tester accounts and remove them from the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Executing the testerExpired command...');

        // Assuming User model has relationships defined with Project, PromptHistory, Image, Suffix
        // Get the expired tester accounts
        $expiredTrialUsers = User::whereHas('subscriptions', function ($query) {
            $query->where('trial_ends_at', '<', Carbon::now())
            ->where('stripe_status', 'active');
        })->get();
        $this->info($expiredTrialUsers);
        foreach ($expiredTrialUsers as $tester) {
            // Delete related records
            $tester->projects()->delete();

            // Delete associated images (will also delete associated records in image_group due to cascading)
            //$tester->images()->delete();

            // Delete associated suffixes (will also delete associated records in suffix_group due to cascading)
            //$tester->suffixes()->delete();

            // Set the stripe_status to 'inactive'
            $tester->subscriptions()->update(['stripe_status' => 'inactive']);

        }

        $this->info('Finished executing the testerExpired command.');

        return Command::SUCCESS;
    }
}
