@extends('layout.master')
@section('content')

   <div class="container">
        <div class="row">
            <div class="col-6 mt-5">
             <div id="carouselExampleFade" class="carousel slide carousel-fade rounded-3 shadow position-relative overflow-hidden" data-bs-ride="carousel"
              data-bs-interval="4000">
                
                <!-- Countdown Timer Overlay Badge -->
                <div class="position-absolute top-0 end-0 m-3 z-3 bg-dark bg-opacity-75 text-warning fw-bold px-3 py-1 rounded-pill border border-warning shadow d-flex align-items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span><span id="carouselTimerSeconds">4</span>s</span>
                </div>

                <!-- Timer Progress Bar
                <div class="position-absolute bottom-0 start-0 w-100 z-3" style="height: 4px; background: rgba(255, 255, 255, 0.2);">
                    <div id="carouselProgressBar" style="height: 100%; width: 100%; background: #ffc107; transition: width 1s linear;"></div>
                </div> -->

                <div class="carousel-inner">
                
                  @foreach($poster as $item)
                   <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{asset('movieImages/'.$item->image)}}" height="400px" width="600px" class="d-block w-100" alt="{{ $item->title }}">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                            <h5 class="m-0 text-white fw-bold">{{ $item->title }}</h5>
                        </div>
                    </div>
                
                   
                  @endforeach
                </div>
               
             </div>
              <div class="p-2 mt-5">
                    <h3 class="text-white fw-bold">{{ __('messages.popular_movies') }}</h3><hr class="bg-white">

                    <div class="row">
                       

                          @foreach($mainImage as $item)
                           @if($item->rating >= 9)
                            <div class="col-4 p-2">
                             <a href="{{route('userShowDetails',$item->id)}}" class="text-white btn fw-bold border-1 border-white">{{$item->title}}</a>    
                            </div>
                           @endif
                         @endforeach
                        
                        
                    </div>

                </div>

            </div>

          <!--right side-->
          <!-- 2. Right Side: Scrollable Movie List (col-6) -->
        <div class="col-md-6 mt-4">
            <h4 class="text-white fw-bold mb-3">{{ __('messages.movie_list') }}</h4><hr>
            
            <!-- Scrollable Container -->
            <div class="pe-2" style="max-height: 600px; overflow-y: auto;">
                <div class="row g-3">
                    @foreach($mainImage as $item)
                        <div class="col-6 col-sm-4 ">
                            <div class="card bg-dark text-white border-0 shadow-sm rounded-3 overflow-hidden h-200">
                                <img src="{{ asset('movieImages/'.$item->image) }}" class="card-img-top " style="height: 230px;" alt="{{ $item->title }}">
                                <div class="card-body p-2 text-center">
                                    <span class="text-warning small fs-7">{{ __('messages.ratings') }} : <i class="fa-solid fa-star"></i> {{ $item->rating ?? 'N/A' }}</span><br>
                                    <a href="{{ route('userShowDetails',$item->id)}}" class="text-white mt-2">{{ __('messages.movie_details') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselEl = document.getElementById('carouselExampleFade');
    if (!carouselEl) return;

    const intervalMs = 4000;
    const totalSeconds = Math.floor(intervalMs / 1000);
    let currentSeconds = totalSeconds;
    let timerInterval = null;

    const timerBadge = document.getElementById('carouselTimerSeconds');
    const progressBar = document.getElementById('carouselProgressBar');

    function updateDisplay() {
        if (timerBadge) {
            timerBadge.textContent = currentSeconds;
        }
        if (progressBar) {
            const percentage = (currentSeconds / totalSeconds) * 100;
            progressBar.style.width = percentage + '%';
        }
    }

    function startTimer() {
        clearInterval(timerInterval);
        currentSeconds = totalSeconds;
        updateDisplay();

        timerInterval = setInterval(function() {
            currentSeconds--;
            if (currentSeconds < 0) {
                currentSeconds = totalSeconds;
            }
            updateDisplay();
        }, 1000);
    }

    carouselEl.addEventListener('slid.bs.carousel', function () {
        startTimer();
    });

    startTimer();
});
</script>
@endsection
