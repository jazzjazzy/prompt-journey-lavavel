<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Subscription is Canceled') }}
        </h2>

        <p>
        <div class="grid grid-cols-3 w-fit border-gray-400 border">
            <div class="span-col-1 px-3 bg-amber-400">
                Grace Period ending
            </div>
            <div class="span-col-2 px-3">
                {{$endGracePeriod['date']}}
            </div>
            <div class="span-col-3 pl-3">
                {{$endGracePeriod['plan']}}
            </div>
        </div>
        </p>


        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before
            deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-subscription-resume')"
    >{{ __('Resume Subscription') }}
    </x-danger-button>

    <x-modal name="confirm-subscription-resume" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('subscription.subscribe.resume') }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want resume your current canceled Subscription?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once you resume Subscription you be charge from you original billing cycle from the :plan, Please enter your password to confirm you would like to permanently delete
                your subscription.', ['plan' => $endGracePeriod['date']]) }}
            </p>

            @if (!is_null($user->password))
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only"/>

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
            </div>
            @endif

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Resume Subscription') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
