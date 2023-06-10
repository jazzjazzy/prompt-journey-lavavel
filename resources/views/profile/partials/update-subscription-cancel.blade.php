<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Cancel Subscription') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-subscription-cancel')"
    >{{ __('Cancel Subscription') }}</x-danger-button>

    <x-modal name="confirm-subscription-cancel" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('subscription.subscribe.cancel') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want cancel your current Subscription?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once you cancel current Subscription, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your subscription.') }}
            </p>
            @if (!is_null($user->password))
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->cancelSubscription->get('password')" class="mt-2" />
            </div>
            @endif
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Cancel Subscription') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
