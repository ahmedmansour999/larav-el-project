<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4"  :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="d-flex flex-column justify-content-center align-items-center mt-4">

        @csrf
        <h1 class="fs-1 fw-bold " style="color:#807e7e"  >Login </h1>

        <!-- Email Address -->
        <div class="col-md-5 mt-4  ">
            <x-input-label class="text-black" for="email" :value="__('Email')" />
            <x-text-input id="email" class=" bg-white text-dark block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="col-md-5 mt-4  ">
            <x-input-label class="text-black" for="password" :value="__('Password')" />

            <x-text-input id="password" class=" bg-white block mt-1 text-dark  w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-dark" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label class="text-black" for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 bg-white text-sm text-gray-700 dark:text-gray-700">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif



            <x-primary-button class="ms-4 btn bg-primary text-black">
                {{ __('Log in') }}
            </x-primary-button>



        </div>
        <div class="links-connect mt-3">
            <a href="/auth/google/redirect" class=" btn btn-primary  "><i class="fab fa-google"></i> Google</a>
            <a href="/auth/github/redirect" class="btn btn-dark "><i class="fab fa-github"></i> Github</a>
        </div>
    </form>
</x-guest-layout>
