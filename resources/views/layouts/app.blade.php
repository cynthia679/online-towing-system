<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Online Towing System')</title>
  <link rel="manifest" href="{{ secure_asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
  <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: sans-serif;
            background-color: green;
            padding: 0;
            margin: 0;
        }
        .container {
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
        }
        nav {
            background-color: #343a40;
            padding: 15px 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        nav a {
            display: inline-block;
            margin: 0 18px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 16px;
            border-radius: 6px;
            transition: background-color 0.4s, color 0.4s, transform 0.3s;
        }
        nav a:hover {
            background-color: #ffc107;
            color: #212529;
            transform: scale(1.05);
        }
        nav a.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    {{-- Header --}}
    @include('partials.header')

    {{-- Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- Flash messages --}}
    @include('partials.flash-message')

    {{-- Header content --}}
    <div id="header-content" class="mb-3"></div>

    {{-- Slider --}}
    <div id="slider" style="width:100%; height:600px; overflow:hidden; position:relative; margin-bottom: 30px; border-radius: 8px;">
       <img id="slideImage" src="{{ secure_asset('images/slide1.jpg') }}"
             style="width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0;" alt="Slide Image">
    </div>

    {{-- Main page content --}}
    @yield('content')

    {{-- Footer --}}
    @include('partials.footer')
</div>

{{-- Slider Script --}}
<script>
    const images = [
       "{{ secure_asset('images/slide1.jpg') }}",
       "{{ secure_asset('images/slide2.jpg') }}",
       "{{ secure_asset('images/slide3.jpg') }}",
       "{{ secure_asset('images/slide4.jpg') }}"
    ];

let index = 0;
const slideTime = 3000;

function changeImage() {
    index = (index + 1) % images.length;

    const slideImage = document.getElementById('slideImage');
    slideImage.src = images[index];

    if (index === 2) {
        slideImage.style.objectFit = 'contain';
    } else {
        slideImage.style.objectFit = 'cover';
    }
}

window.addEventListener('load', function () {
    setInterval(changeImage, slideTime);
});
</script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Categories Script --}}
<script>
    function loadCategories() {
        fetch('{{ url("/categories-partial") }}')
            .then(response => response.text())
            .then(html => document.getElementById('header-content').innerHTML = html)
            .catch(error => console.error('Error loading categories:', error));
    }
</script>

{{-- Logout helper --}}
<script>
    function logout(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}
</script>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function () {
                    console.log('Service Worker registered');
                })
                .catch(function (error) {
                    console.error('Service Worker registration failed:', error);
                });
        });
    }
</script>
</body>
</html>
