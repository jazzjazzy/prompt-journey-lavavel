<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex justify-center items-center pb-10">
            <div>
                <a href="https://www.youtube.com/watch?v=Os_VYrbCL7E?autoplay=1&vq=hd1080&controls=0"
                   class="popup-youtube inline-flex items-center ml-10 px-1 pt-1 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                    <div class="pt-3 flex justify-center items-center">
                        <div>Watch me
                            <div class="text-xs text-gray-400">version 1.2</div>
                        </div>
                        <div><i class="ml-3 fa-solid fa-play-circle text text-red-400 text-[35px]"></i></div>
                        <div class="text-xs text-gray-200">version 1.2</div>
                    </div>
                </a>
            </div>
        </div>


        <div>
            <a href="{{ route('register') }}"
               class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Register
                now</a>
        </div>
        <hr class="border border-slate-300 mt-6 mb-6">
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
        <div class="m-0 p-0 text-xs text-gray-400">
            <div data-url="{{route('tos')}}" title="Term of service" class="open-modal inline-block cursor-pointer" data-model-size="xl">Terms of Service</div>
            | <div data-url="{{route('privacy')}}" title="Privacy Policy" class="open-modal inline-block cursor-pointer" data-model-size="xl">Privacy Policy</div>
        </div>
    </form>
    <hr class="border border-slate-300 mt-3 mb-6">
    <div class="mt-5 mx-8">
        <a href="/auth/google/redirect">
            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                <div class="flex inline-flex bg-green-900 ">
                    <i class="fab fa-google m-3 text text-white text-[35px]"></i>
                </div>
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    Login with Google
                </div>
            </div>
        </a>
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
                </a>-->
        <a href="/auth/facebook/redirect">
            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                <div class="flex inline-flex bg-slate-800">
                    <i class="fab fa-facebook m-3 text text-white text-[35px]"></i>
                </div>
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    Login with Facebook
                </div>
            </div>
        </a>
    </div>
</x-guest-layout>
