<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.app_name') }}</title>
  
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" 
integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA==" 
crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>


<body class="bg-dark-blue-gradient">

   <nav class="navbar navbar-expand-lg bg-dark navbar-dark data-bs-theme='dark' sticky-top z-5">
  <div class="container-fluid">
    <h1 class="text-warning fs-1 fw-bold pe-3">{{ __('messages.app_name') }}</h1>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item">
          <a class="nav-link text-white fw-bold fs-4 pe-3" aria-current="page" href="{{ route('userShowMainPage') }}">{{ __('messages.home') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/*') ? 'active' : '' }}" href="{{ route('adminMovieList') }}">{{ __('messages.admin_control') }}</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ __('messages.menu') }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">{{ __('messages.genre_action') }}</a></li>
            <li><a class="dropdown-item" href="#">{{ __('messages.other') }}</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">{{ __('messages.help') }}</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" method="GET" action="{{ route('search') }}">
        <input class="form-control me-2 bg-dark text-white border-secondary" type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_movies') }}" aria-label="Search"/>
        <button class="btn btn-outline-warning me-2" type="submit">{{ __('messages.search') }}</button>
      </form>

      <!-- Language Switcher Dropdown -->
      <div class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-globe me-1"></i> {{ app()->getLocale() == 'ja' ? '🇯🇵' : '🇬🇧' }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('changeLanguage', 'en') }}">
              🇬🇧 English
            </a>
          </li>
          <li>
            <a class="dropdown-item {{ app()->getLocale() == 'ja' ? 'active' : '' }}" href="{{ route('changeLanguage', 'ja') }}">
              🇯🇵 日本語
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>

    @yield('content')
    
 

    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
crossorigin="anonymous">

</script>

<!--image preview-->
<script>
        function previewImage(event){
            var reader= new FileReader();
            reader.onload=function(){
                let output= document.getElementById('output');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
  
   
</script>
</html>