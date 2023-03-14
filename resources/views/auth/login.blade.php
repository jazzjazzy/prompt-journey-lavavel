<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                       name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
               href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="m-0 p-0 text-xs text-gray-400"><a href="/terms-of-service">Terms of Service</a> | <a href="/privacy-policy">Privacy Policy</a></div>
    </form>
    <hr class="border border-slate-300 mt-3 mb-6">
    <div class="mt-5 mx-8">
<!--        <a href="/auth/google/redirect">
        <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
            <div class="flex inline-flex bg-green-900 ">
                <i class="fab fa-google m-3 text text-white text-[35px]"></i>
            </div>
            <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                Login with Google
            </div>
        </div>
        </a>-->
        <a href="/auth/github/redirect">
            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                <div class="flex inline-flex bg-gray-900 ">
                    <i class="fab fa-github m-3 text text-white text-[35px]"></i>
                </div>
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    Login with Github
                </div>
            </div>
        </a>
<!--        <a href="/auth/twitter/redirect">
            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                <div class="flex inline-flex bg-sky-500">
                    <i class="fab fa-twitter m-3 text text-white text-[35px]"></i>
                </div>
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    Login with Twitter
                </div>
            </div>
        </a>
        <a href="/auth/facebook/redirect">
            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                <div class="flex inline-flex bg-slate-800">
                    <i class="fab fa-facebook m-3 text text-white text-[35px]"></i>
                </div>
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    Login with Facebook
                </div>
            </div>
        </a>-->
    </div>
</x-guest-layout>
