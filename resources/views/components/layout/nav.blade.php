<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" width="100"/>
            </a>
        </div>

        <div class="flex gap-x-5 items-center">
                @auth
                    <a href="/profile/edit">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn">Log Out</button>
                </form>
            @endauth

            @guest
                <a href="/login" >Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>
