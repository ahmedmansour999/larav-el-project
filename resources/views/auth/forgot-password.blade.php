<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center mt-5">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column justify-content-center align-items-center mt-4" >
        @csrf

        <!-- Email Address -->
        <div class="col-md-5" >
            <x-input-label for="email" class="text-black" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-dark bg-white" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 col-md-5 text-dark">
            <x-primary-button class="ms-4 btn bg-primary text-dark">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
