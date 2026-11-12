<x-layout>
    <x-form
        title="Log In"
        description="Glad to have you back."
    >
        <form method="POST" action="{{ route('login') }}" class="mt-10 space-y-6 bg-card border border-border rounded-xl p-6">
            @csrf

            <x-form.field name="email" label="Email" type="email" autocomplete="email" required />
            <x-form.field name="password" label="Password" type="password" autocomplete="new-password" required />

            <button type="submit" class="btn w-full h-10" data-test="login-button">Log In</button>
            @error('errors')
            <p class="error">{{ $message }}</p>
            @enderror
        </form>
    </x-form>
</x-layout>
