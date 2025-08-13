<header class="mb-3">
    <h2 class="text-center text-white bg-dark py-3">Online Vehicle Towing System</h2>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                {{-- Home --}}
                <li class="nav-item mx-2" onmouseover="showHomeContent()" onmouseout="hideHomeContent()">
                    <a class="nav-link" href="#">Home</a>
                </li>

                {{-- Welcome --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Welcome
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/') }}">About Us</a></li>
                        <li><a class="dropdown-item" href="#" onclick="showContactContent(); return false;">Contact</a></li>
                    </ul>
                </li>

                {{-- Client Login --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Client Login
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('client.login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('client.register') }}">Create Account</a></li>
                    </ul>
                </li>

                {{-- Dashboard --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Dashboard
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/dashboard') }}">Main Dashboard</a></li>

                    </ul>
                </li>

                {{-- Categories --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="loadCategories(); return false;">All Categories</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- ✅ Who Are We content -->
    <div id="homeContent" class="bg-light text-dark p-4 rounded shadow-sm mt-2 mx-3" style="display: none;">
        <h5>Who Are We?</h5>
        <p>
            This is an online vehicle tracking company offering cutting-edge GPS solutions tailored to meet your needs.
            Our responsive tracking systems ensure real-time monitoring from any device, empowering you to manage your fleet with ease and efficiency.
            Thank you for trusting us.
        </p>
    </div>

    <!-- ✅ Contact content -->
    <div id="contactContent" class="bg-light text-dark p-4 rounded shadow-sm mt-2 mx-3" style="display: none;">
        <h5>Contact</h5>
        <p>Phone: +254741562763</p>
    </div>

    <!-- ✅ All Categories content -->
    <div id="categoriesContent" class="bg-light text-dark p-4 rounded shadow-sm mt-2 mx-3" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Categories</h5>
            <button onclick="document.getElementById('categoriesContent').style.display='none'" class="btn btn-sm btn-outline-danger">X</button>
        </div>
        <div id="categoriesList" class="mt-2">Loading...</div>
    </div>

    <hr>
</header>

<!-- ✅ JavaScript -->
<script>
    function showHomeContent() {
        document.getElementById('homeContent').style.display = 'block';
    }

    function hideHomeContent() {
        document.getElementById('homeContent').style.display = 'none';
    }

    function showContactContent() {
        document.getElementById('contactContent').style.display = 'block';
        setTimeout(function () {
            document.getElementById('contactContent').style.display = 'none';
        }, 5000);
    }

    function loadCategories() {
        const categoriesDiv = document.getElementById('categoriesContent');
        const categoriesList = document.getElementById('categoriesList');

        categoriesDiv.style.display = 'block';
        categoriesList.innerHTML = 'Loading...';

        fetch("{{ url('/categories-partial') }}")
            .then(response => response.text())
            .then(html => {
                categoriesList.innerHTML = html;
            })
            .catch(error => {
                categoriesList.innerHTML = 'Failed to load categories.';
                console.error(error);
            });

        setTimeout(() => {
            categoriesDiv.style.display = 'none';
        }, 7000);
    }
</script>
