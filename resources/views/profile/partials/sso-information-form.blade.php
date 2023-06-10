<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Single Sign-in Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Your current account is using Single Sign in see details below') }}
        </p>

        <div id="providers">

            <div class="border border-black rounded-sm shadow-lg m-3 flex justify-items-center">
                @if ($user->provider === 'google')
                    <div class="flex inline-flex bg-green-900 ">
                        <i class="fab fa-google m-3 text text-white text-[35px]"></i>
                    </div>
                @elseif ($user->provider === 'github')
                    <div class="flex inline-flex bg-gray-900">
                        <i class="fab fa-gitHub m-3 text text-white text-[35px]"></i>
                    </div>
                @elseif ($user->provider === 'facebook')
                    <div class="flex inline-flex bg-sky-900 ">
                        <i class="fab fa-twitter m-3 text text-white text-[35px]"></i>
                    </div>
                @else
                    <div class="text-lg text-red-600 p-2">Provider `{{$user->provider}}` not found</div>
                @endif
                <div class="mx-4 text-lg font-extrabold inline-block align-baseline my-auto">
                    {{ $user->email }}
                </div>
            </div>
        </div>
    </header>
</section>
