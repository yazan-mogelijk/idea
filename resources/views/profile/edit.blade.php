<x-layout>
    <x-form
        title="Edit an account"
        description="Need to make a tweak."
    >
        <form method="POST" action="{{ route('profile.update') }}" class="mt-10 space-y-6 bg-card border border-border rounded-xl p-6">
            @csrf
            @method('PATCH')

            <x-form.field name="name" label="Name" required :value="$user->name"/>
            <x-form.field name="email" label="Email" type="email" autocomplete="email" required :value="$user->email"/>
            <x-form.field name="password" label="New Password" type="password" autocomplete="new-password" />

            <button type="submit" class="btn w-full h-10">Update Account</button>
            @error('errors')
            <p class="error">{{ $message }}</p>
            @enderror
        </form>
    </x-form>
</x-layout>
