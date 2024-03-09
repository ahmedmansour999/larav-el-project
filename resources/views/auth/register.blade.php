<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="d-flex flex-column justify-content-center align-items-center mt-4" >
        @csrf
            <h1 class="fs-1 fw-bold " style="color:#807e7e"  >Signup Now</h1>
        <!-- Name -->
        <div class="col-md-5 mt-4  ">
            <x-input-label for="name" class="text-black" value="Name"  />
            <x-text-input id="name" class="block text-dark bg-white mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 col-md-5">
            <x-input-label for="email" class="text-black" :value="__('Email')" />
            <x-text-input id="email" class="block text-dark bg-white mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 col-md-5">
            <x-input-label for="password" class="text-black" :value="__('Password')" />

            <x-text-input id="password" class="block text-dark bg-white mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 col-md-5">
            <x-input-label for="password_confirmation" class="text-black" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block text-dark bg-white mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 class="text-black" col-md-5">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 btn bg-success text-black">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
