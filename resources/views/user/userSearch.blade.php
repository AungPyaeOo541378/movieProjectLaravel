@extends('layout.master')
@section('content')

<div class="container py-5">
    <!-- Search Bar & Results Summary Header -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-secondary shadow-lg rounded-4 p-4">
                <h2 class="text-center fw-bold mb-3">
                    <i class="fa-solid fa-magnifying-glass text-warning me-2"></i>Search Movies
                </h2>
                <form action="{{ route('search') }}" method="GET" class="d-flex gap-2">
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-lg bg-dark text-white border-secondary" 
                           placeholder="{{ __('messages.search_movies') }}" 
                           value="{{ request('search') }}"
                           required>
                    <button type="submit" class="btn btn-warning btn-lg px-4 fw-bold">
                        <i class="fa-solid fa-search"></i> {{ __('messages.search') }}
                    </button>
                </form>

                @if(request('search'))
                    <div class="mt-3 text-center">
                        <span class="text-secondary fs-5">
                            Search results for: <strong class="text-warning">"{{ request('search') }}"</strong>
                        </span>
                        <span class="badge bg-secondary ms-2 fs-6">{{ $movies->total() }} found</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Movie Results Grid -->
    <div class="row g-4">
        @if($movies->count() > 0)
            @foreach($movies as $movie)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card bg-dark text-white border-secondary h-100 shadow-sm rounded-3 overflow-hidden position-relative hover-card">
                        <!-- Rating Badge -->
                        <div class="position-absolute top-0 end-0 m-2 bg-dark bg-opacity-75 text-warning fw-bold px-2 py-1 rounded-pill small border border-warning z-2">
                            <i class="fa-solid fa-star"></i> {{ $movie->rating ?? 'N/A' }}
                        </div>

                        <!-- Poster Image -->
                        <a href="{{ route('userShowDetails', $movie->id) }}">
                            <img src="{{ asset('movieImages/'.$movie->image) }}" 
                                 class="card-img-top object-fit-cover" 
                                 style="height: 320px; width: 100%;" 
                                 alt="{{ $movie->title }}"
                                 onerror="this.src='https://via.placeholder.com/300x420?text=No+Poster'">
                        </a>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="card-title fw-bold text-truncate text-white mb-2" title="{{ $movie->title }}">
                                    {{ $movie->title }}
                                </h5>
                                <p class="card-text text-secondary small mb-2">
                                    {{ Str::limit($movie->description, 70) }}
                                </p>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center text-secondary small mb-3">
                                    <span><i class="fa-solid fa-calendar-days me-1"></i>{{ $movie->release_date }}</span>
                                </div>
                                <a href="{{ route('userShowDetails', $movie->id) }}" class="btn btn-outline-warning w-100 fw-bold">
                                    <i class="fa-solid fa-circle-info me-1"></i> {{ __('messages.movie_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- No Results State -->
            <div class="col-12 text-center py-5">
                <div class="card bg-dark text-white border-secondary p-5 d-inline-block rounded-4 shadow">
                    <i class="fa-solid fa-film fa-4x text-secondary mb-3"></i>
                    <h3 class="fw-bold">No Movies Found</h3>
                    <p class="text-secondary mb-4">We couldn't find any movies matching your search term.</p>
                    <a href="{{ route('userShowMainPage') }}" class="btn btn-warning fw-bold px-4">
                        <i class="fa-solid fa-house me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-5">
        {{ $movies->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

