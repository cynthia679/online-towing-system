<header class="mb-3">
    <h2 class="text-center text-white bg-dark py-3">Online Vehicle Towing System</h2>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">

                {{-- Home --}}
                <li class="nav-item mx-2" style="position: relative;">
                    <a class="nav-link" href="#" id="home-link">Home</a>
                    <span id="home-message"
                          style="display:none; position: absolute; white-space: nowrap; background: none; color: black; font-weight: 600; font-size: 20px; padding: 2px 6px; top: 100%; margin-top: 5px;">
                        Welcome to the Online Vehicle Towing System – reliable, fast, and safe towing services.
                    </span>
                </li>

                {{-- Welcome --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Welcome
                    </a>
                    <ul class="dropdown-menu" style="width: 200px; padding: 10px;">
                        <li><a class="dropdown-item" href="{{ url('/') }}">About Us</a></li>
                        <li><a class="dropdown-item" href="#" id="contact-link">Contact</a></li>
                    </ul>
                </li>

                {{-- Guest Login/Register --}}
                @guest
                    {{-- Client --}}
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Client
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('client.login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.register') }}">Create Account</a></li>
                        </ul>
                    </li>

                    {{-- Admin --}}
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.login') }}">Login</a></li>
                        </ul>
                    </li>

                    {{-- Driver --}}
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Driver
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('driver.login') }}">Login</a></li>
                        </ul>
                    </li>
                @endguest

                {{-- Authenticated Dashboard & Logout --}}
                @auth
                    @php
                        $role = Auth::user()->role;
                        $dashboardRoute = match($role) {
                            'admin' => 'admin.dashboard',
                            'client' => 'client.dashboard',
                            'driver' => 'driver.dashboard',
                            default => 'home'
                        };
                    @endphp

                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Dashboard
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route($dashboardRoute) }}">
                                    {{ ucfirst($role) }} Dashboard
                                </a>
                            </li>

                            @if($role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.drivers.index') }}">
                                        Manage Drivers
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.requests.index') }}">
                                        Manage Requests
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories.index') }}">
                                        Manage Categories
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dropdown-item" href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth

                {{-- Categories Dropdown --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        {{-- Remove loadCategories() injection --}}
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}">All Categories</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Hidden logout form --}}
    @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    {{-- Contact info + Google Map --}}
    <div id="contact-info" style="display:none; background:#f8f9fa; padding:10px; margin:10px 0; border-radius:5px;">
        <p>Email: cynthiachebet5@gmail.com</p>
        <p>Phone: +254741562763</p>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.482134627632!2d36.78941841423807!3d-1.2810864361645042!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f11f1e66eaf09%3A0x8c8ff0b3d3b3e5!2sNairobi!5e0!3m2!1sen!2ske!4v1694176891714!5m2!1sen!2ske"
            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <hr>
</header>

<script>
    const homeLink = document.getElementById('home-link');
    const homeMessage = document.getElementById('home-message');

    homeLink.addEventListener('mouseenter', (e) => {
        homeMessage.style.display = 'inline';
    });

    homeLink.addEventListener('mousemove', (e) => {
        const rect = homeLink.getBoundingClientRect();
        homeMessage.style.left = (e.clientX - rect.left) + 'px';
    });

    homeLink.addEventListener('mouseleave', () => {
        homeMessage.style.display = 'none';
    });

    const contactLink = document.getElementById('contact-link');
    const contactInfo = document.getElementById('contact-info');
    contactLink.addEventListener('click', (e) => {
        e.preventDefault();
        contactInfo.style.display = contactInfo.style.display === 'none' ? 'block' : 'none';
    });
</script>
