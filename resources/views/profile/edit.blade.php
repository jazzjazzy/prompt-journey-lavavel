<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    @section('content')

    @php $messageBag = session('errors'); @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (!$user->provider)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
                @php
                    $bg = ($messageBag && ($messageBag->get('password') !== null || $messageBag->get('current_password') !== null)) ? 'bg-red-100' : 'bg-white';
                @endphp
                <div class="p-4 sm:p-8 {{ $bg }} dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            @else
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.sso-information-form')
                    </div>
                </div>
            @endif

            @if ($user->isSubscribed())
                @php
                $bg = (session('error-cancel') !== null) ? 'bg-red-100' : 'bg-white';
                @endphp
                <div class="p-4 sm:p-8 {{ $bg }} dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-subscription-cancel')
                    </div>
                    @if (session('error-cancel') !== null)
                    <div class="alert alert-error mt-3">
                        {{ session('error-cancel') }}
                    </div>
                    @endif
                </div>
            @endif

            @if (isset($endGracePeriod) && $endGracePeriod !== null)
                @php
                $bg = (session('error-resume') !== null) ? 'bg-red-100' : 'bg-white';
                @endphp
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-subscription-graceperiod')
                    </div>
                    @if (session('error-resume') !== null)
                    <div class="alert alert-error mt-3">
                        {{ session('error-resume') }}
                    </div>
                    @endif
                </div>
            @endif

            @php
            $bg = (session('error-destroy') !== null) ? 'bg-red-100' : 'bg-white';
            @endphp

            <div class="p-4 sm:p-8 {{ $bg }} dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
                @if (session('error-destroy') !== null)
                    <div class="alert alert-error mt-3">
                        {{ session('error-destroy') }}
                    </div>
                @endif
            </div>


        </div>
    </div>
    @endsection
</x-app-layout>
