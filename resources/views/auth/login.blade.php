<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <div class="w-full sm:max-w-md mt-1 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="flex justify-center items-center pb-10">
                <div>
                    <a href="https://www.youtube.com/watch?v=Os_VYrbCL7E?autoplay=1&vq=hd1080&controls=0"
                       class="popup-youtube inline-flex items-center ml-10 px-1 pt-1 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        <div class="pt-3 flex justify-center items-center">
                            <div>Watch me
                                <div class="text-xs text-gray-400">version 1.3</div>
                            </div>
                            <div><i class="ml-3 fa-solid fa-play-circle text text-red-400 text-[35px]"></i></div>

                        </div>
                    </a>
                </div>
            </div>


            <div>
                <a id="register" href="{{ route('register') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Register
                    now</a>
            </div>
            <hr class="border border-slate-300 mt-6 mb-6">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required
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
                <div data-url="{{route('tos')}}" title="Term of service" class="open-modal inline-block cursor-pointer"
                     data-model-size="xl">Terms of Service
                </div>
                |
                <div data-url="{{route('privacy')}}" title="Privacy Policy"
                     class="open-modal inline-block cursor-pointer" data-model-size="xl">Privacy Policy
                </div>
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
    </div>
    <div class="w-2/5 mt-8 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <h1 class="text-3xl bold mb-5" >Prompt Journey - Ignite Your Creative Voyage</h1>
        <p class="mb-4">Welcome to Prompt Journey, your go-to prompt creation tool for mid-journey experiences. Our platform is
            designed to spark your creativity, provide fresh inspiration, and offer a unique approach to prompt
            creation. Whether you're a seasoned writer or just starting your journey, Prompt Journey is the key to
            unlocking your creative potential.</p>

        <p class="mb-4">At Prompt Journey, we understand that every creative journey is unique. That's why we've developed a tool
            that allows you to keep a detailed history of your prompt attempts, save links to inspiring images, and
            maintain an organized list of suffixes. Our platform is more than just a prompt generator; it's a
            comprehensive tool that supports your creative process from start to finish.</p>

        <p class="mb-4">Our platform is designed to overcome the challenges often associated with prompt creation. We provide clear
            steps and tools to help you generate prompts that are specific to your mid-journey experiences. With Prompt
            Journey, you'll never have to worry about forgetting a great idea or losing track of your progress.</p>

        <p class="mb-4">Prompt Journey is not just a tool; it's a community. We invite you to join our user base of creative
            individuals who share their prompts, provide feedback, and inspire each other. Our platform is a space where
            you can try new ideas, share your latest creations, and get feedback from a supportive community.</p>

        <p class="mb-4">Our goal is to provide a platform that is as unique as the prompts you create. We're constantly updating our
            tool with the latest features to ensure that you have everything you need to create prompts that are
            intricate, engaging, and completely your own.</p>

        <p class="mb-4">At Prompt Journey, we believe that every creative journey deserves a great start. That's why we're committed
            to providing a prompt creation tool that is easy to use, supportive, and designed to help you create the
            best prompts possible. So why wait? Start your creative journey with Prompt Journey today.</p>
    </div>
        <div class="w-4/5 mt-8 mb-8 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="w-full text-center pb-3">
                <h1 class="text-5xl bold mb-5" >Pricing</h1>
            </div>
            @csrf
            <div class="flex justify-center mb-1">
                <span class="text-md px-3">Monthly</span>
                <label for="toggle" class="toggle-switch bg-blue-200 cursor-pointer relative w-12 h-6 rounded-full">
                    <input type="checkbox" id="toggle" class="sr-only peer">
                    <span class="w-2/5 h-4/5 bg-blue-400 absolute rounded-full left-1 top-0.5 peer-checked:bg-blue-600
        peer-checked:left-6 transition-all duration-500"></span>
                </label>


                <span class="text-md px-3">Yearly</span>
            </div>
            <div class="flex justify-center mb-3 p-0 m-0 h-6"><span id="savings"
                                                                    class="hidden">Save 2 month when you pay yearly</span></div>

            <div class="Pricing grid grid-cols-4 w-3/4 mx-auto gap-5">
                @foreach ($plans as $plan)
                <div
                    class="pricing-free bg-blue-900 drop-shadow-lg text-gray-100 col-span-1 rounded-lg border-2
            border-gray-300 p-5 bg-gradient-to-r
            @if ($plan->slug == 'monthly-pro' || $plan->slug == 'Yearly-pro') from-amber-500 via-orange-500 to-amber-500 @else from-blue-500 via-blue-500 to-blue-500 @endif
            @if ($plan->abbreviation == '/Year') yearly hidden @elseif(($plan->abbreviation == '/Month')) monthly @endif ">
                    <div class="heading w-full mx-auto font-bold text-2xl my-6">
                        <h2 class="text-center">{{$plan->name}}</h2>
                    </div>
                    <div class="price text-6xl font-bold my-3 text-center">${{$plan->price}}
                        <span class="text-sm">{{$plan->abbreviation}}</span>
                    </div>
                    <div class="description h-16 text-sm text-">{{$plan->description}}</div>
                    <div class="list w-full p-4 my-auto">
                        <ul>

                            @php
                            $arrayData = json_decode($plan->metaData, true);
                            @endphp

                            @foreach ( $arrayData as $data)
                            <li class="text-xs">
                                @if ($data['checked'] == 'true')
                                <i class="w-[1rem] h-[1rem] fa-sharp fa-solid fa-check fa-beat-fade text-lime-400"></i>
                                @else
                                <i class="w-[1rem] h-[1rem] fa-sharp fa-solid fa-x text-red-500"></i>
                                @endif
                                {{$data['text']}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    <div>
        <script type="module">

            $(document).ready(function () {
                const toggleSwitch = $('#toggle');
                const div1 = $('.monthly');
                const div2 = $('.yearly');
                const savings = $('#savings');

                // check if toggle is checked on page load
                if (toggleSwitch.prop('checked')) {
                    div1.removeClass('block');
                    div1.addClass('hidden');
                    div2.removeClass('hidden');
                    div2.addClass('block');
                    savings.addClass('block');
                    savings.removeClass('hidden');
                }


                toggleSwitch.on('change', function () {

                    if (toggleSwitch.prop('checked')) {
                        div1.removeClass('block');
                        div1.addClass('hidden');
                        div2.removeClass('hidden');
                        div2.addClass('block');
                        savings.addClass('block');
                        savings.removeClass('hidden');
                    } else {
                        div2.removeClass('block');
                        div2.addClass('hidden');
                        div1.removeClass('hidden');
                        div1.addClass('block');
                        savings.removeClass('block');
                        savings.addClass('hidden');
                    }
                });
            });

        </script>
</x-guest-layout>
