<x-layout>
    <x-form
        title="Create an account"
        description="Start capturing your ideas today."
    >
        <form method="POST" action="{{ route('register.store') }}" class="mt-10 space-y-6 bg-card border border-border rounded-xl p-6">
            @csrf

            <x-form.field name="name" label="Name" required />
            <x-form.field name="email" label="Email" type="email" autocomplete="email" required />
            <x-form.field name="password" label="Password" type="password" autocomplete="new-password" required />

            <button type="submit" class="btn w-full h-10">Create Account</button>
            @error('errors')
            <p class="error">{{ $message }}</p>
            @enderror
        </form>
    </x-form>
</x-layout>
