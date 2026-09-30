@extends('layout.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <h1 class="text-white">{{ __('messages.movie_details_user') }}</h1>
            <div class="row">
                  <div class="col-4">
              @if($movie->image_type=='poster')
             <img src="{{asset('movieImages/'.$movie->image)}}" alt="" class="w-100 h-50 mt-5">
             @else
              <img src="{{asset('movieImages/'.$movie->image)}}" alt="" class="w-50 h-80 mt-5">
             @endif
            </div>
            <div class="col-8 ">
               <table class="table table-dark mt-4 " style="width: 800px;height: 500px">
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.title') }}</td>
                    <td>{{$movie->title}}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.description') }}</td>
                    <td>{{$movie->description}}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.movie_type') }}</td>
                    <td>{{$movie->movie_type}}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.director') }}</td>
                    <td>{{$movie->director}}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.rating') }}</td>
                    <td class="text-warning small fs-7">★ {{ $movie->rating ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.duration') }}</td>
                    <td>{{$movie->duration}}</td>
                </tr>
                <tr>
                    <td class="text-primary fw-bold">{{ __('messages.release_date') }}</td>
                    <td>{{$movie->release_date}}</td>
                </tr>
               </table>
               <a href="{{route('adminMovieList')}}" class="btn btn-primary  align-items-end mt-5 "> <i class="fa-solid fa-backward me-1" style="color: rgba(205, 202, 227, 1);"></i>{{ __('messages.back') }}</a>
            </div>

            
            </div>
         
        </div>
    </div>
</div>
@endsection