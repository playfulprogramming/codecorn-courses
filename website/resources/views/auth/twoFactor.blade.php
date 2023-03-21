<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        @if (session()->has('message'))
            <p class="alert alert-info">
                {{ session()->get('message') }}
            </p>
        @endif
        <form method="POST" action="{{ route('verify.store') }}">
            @csrf
            <h1>{{ __('Two Factor Verification')}}</h1>
            <p class="text-muted">
                {{ __('You have received an email which contains two factor login code.
                                            If you haven\'t received it, press') }}
                <a class="font-bold text-white" href="{{ route('verify.resend') }}">{{ __('here') }}</a>.
            </p>

            <!-- 2fa code -->
            <div class="mt-4">
                <x-input-label for="two_factor_code" :value="__('2fa code')" />
                <x-text-input id="two_factor_code" class="block w-full mt-1" type="text" name="two_factor_code"
                    required autofocus autocomplete="two_factor_code" />
                <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="w-1/4">
                    <x-primary-button class="">
                        {{ __('Verify') }}
                    </x-primary-button>
                </div>
                <div class="w-1/4">
                    <x-secondary-button class="" href="#"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        {{ __('Logout') }}
                    </x-secondary-button>
                </div>
            </div>
        </form>
    </div>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</x-guest-layout>
