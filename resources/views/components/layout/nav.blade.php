<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="100"/>
            </a>
        </div>
        <div class="flex gap-x-5 items-center">
            @guest
                <a href="/register" class="">Register</a>
                <a href="/login" class="btn">Sign In</a>
            @endguest

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
