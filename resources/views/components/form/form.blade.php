@props(['title', 'description'])

<div class="max-w-md mx-auto">

    <div class="flex min-h-[cal(100dvh-4rem)] items-center justify-center px-4 flex-col">
        <div class="w-full max-w-md">
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
                <p class="mt-2 text-muted-foreground">{{ $description }}</p>
            </div>
        </div>
    </div>

    {{ $slot }}
</div>
