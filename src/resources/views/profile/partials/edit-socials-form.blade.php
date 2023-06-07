<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Social Media') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your social media accounts to gain access to their statistics") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.socials') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="github" :value="__('GitHub')" />
            <x-text-input id="github" name="github" type="text" class="mt-1 block w-full" :value="old('github', $user->github->username)" required autofocus autocomplete="github" />
            <x-input-error class="mt-2" :messages="$errors->get('github')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'socials-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
