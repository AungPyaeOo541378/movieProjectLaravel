@extends('layout.master')
@section('content')

<div class="container">
    <form action="{{route('update')}}" method="POST" enctype="multipart/form-data">
        @csrf
            
      <div class="row">
       
            
            <!--left side image selection-->
        <div class="col-6">
             <div class="col-12 mt-2 mb-2">
            <a href="{{route('adminMovieList')}}" class="btn btn-primary ">{{ __('messages.back') }}</a>
        </div>
            @if($data->image_type=='poster')
             <img src="{{asset('movieImages/'.$data->image)}}" alt="" class="w-140 h-50 mt-5" id="output">
             @else
              <img src="{{asset('movieImages/'.$data->image)}}" alt="" class="w-50 h-80 mt-5" id="output">
             @endif
             <input type="file" name="image" id="image" class="form-control mt-3" onchange="previewImage(event)">
             <div class="mt-5">
                <!--take old image to database-->
                 <input type="hidden" name="old_image" value="{{$data->image}}">
                <!--take old image to database-->

                <!--id pass to update function-->
                <input type="hidden" name="id" value="{{$data->id}}">
                <!--id pass to update function-->



                <!--update button-->
                <input type="submit" class="btn btn-danger text-white fs-5 fw-bold mt-5" value="{{ __('messages.update') }}">
                <!--update button-->




            </div>
            
        </div>
            <!--right side-->
        <div class="col-6">
            <!--Title-->
           <div>
                <label for="" class="text-white fs-5 fw-bold mt-3" >{{ __('messages.title') }}</label>
                <input type="text" name="title" placeholder="{{ __('messages.title') }}" value="{{old('title',$data->title)}}" class="form-control mt-2 @error('title') is-invalid @enderror"/>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Movie Image Type Poster or Main movie-->
            <div>
               <div class=" mt-2">
                <label for="image_type" class="text-white fs-5 fw-bold mt-2">{{ __('messages.image_type') }}</label><br>
                <input type="radio" name="image_type" class="form-check-input @error('image_type') is-invalid @enderror"
                 value="poster" {{old('image_type',$data->image_type) == 'poster' ? 'checked' : ''}} id="">
                <label for="" class="text-white">{{ __('messages.poster') }}</label>
              
                <input type="radio" name="image_type" class="form-check-input ms-2 @error('image_type') is-invalid @enderror"
                value="mainImage" {{old('image_type',$data->image_type) == 'mainImage' ? 'checked' : ''}} id="">
                <label for="" class="text-white">{{ __('messages.movie_image') }}</label>

                 @error('image_type')
               <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
               </span>
               @enderror
               </div>
              

            </div>
            <!--Description-->
            <div>
                <label for="description" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.description') }}</label>
                <textarea name="description" rows="5" class="form-control mt-2 @error('description') is-invalid @enderror" placeholder="{{ __('messages.description') }}">{{old('description',$data->description)}}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Movie Type-->
            <div>
                <label for="movie_type" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.movie_type') }}</label>
                 <select name="movie_type" id="" class="form-control mt-2 @error('movie_type') is-invalid @enderror">
                    <option value="" {{ old('movie_type',$data->movie_type) == "" ? "selected" : "" }}>{{ __('messages.select_movie_type') }}</option>
                    <option value="Action" {{ old('movie_type',$data->movie_type) == "Action" ? "selected" : "" }}>{{ __('messages.genre_action') }}</option>
                    <option value="Superhero" {{ old('movie_type',$data->movie_type) == "Superhero" ? "selected" : "" }}>{{ __('messages.genre_superhero') }}</option>
                    <option value="Horror" {{ old('movie_type',$data->movie_type) == "Horror" ? "selected" : "" }}>{{ __('messages.genre_horror') }}</option>
                    <option value="Anime" {{ old('movie_type',$data->movie_type) == "Anime" ? "selected" : "" }}>{{ __('messages.genre_anime') }}</option>
                    <option value="Romance" {{ old('movie_type',$data->movie_type) == "Romance" ? "selected" : "" }}>{{ __('messages.genre_romance') }}</option>
                    <option value="Drama" {{ old('movie_type',$data->movie_type) == "Drama" ? "selected" : "" }}>{{ __('messages.genre_drama') }}</option>
                 </select>
                 @error('movie_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Director-->
            <div>
                <label for="director" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.director') }}</label>
                <input type="text" name="director" value="{{old('director',$data->director)}}" class="form-control mt-2 @error('director') is-invalid @enderror" placeholder="{{ __('messages.director') }}"/>
                @error('director')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Rating-->
            <div>
               <label for="rating" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.rating') }}</label>
               <select name="rating" class="form-select mt-2 @error('rating') is-invalid @enderror">
                 <option value="">{{ __('messages.select_rating') }}</option>
                 @for($i = 1; $i <= 10; $i++)
                 <option value="{{ $i }}" {{ old('rating',$data->rating) == (string)$i ? 'selected' : '' }}>{{ $i }} {{ __('messages.stars') }}</option>
                 @endfor
               </select>
                 @error('rating')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Duration-->
            <div>
                <label for="duration" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.duration') }}</label>
                <input type="text" name="duration" value="{{old('duration',$data->duration)}}" class="form-control mt-2 @error('duration') is-invalid @enderror" placeholder="{{ __('messages.duration_placeholder') }}"/>
                @error('duration')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--Release Date-->
            <div>
                <label for="release_date" class="text-white fs-5 fw-bold mt-2" >{{ __('messages.release_year') }}</label>
               <div class="mt-2">
               <select name="release_date" class="form-select @error('release_date') is-invalid @enderror">
                <option value="">{{ __('messages.select_release_year') }}</option>
                @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ old('release_date',$data->release_date) == $year ? 'selected' : '' }}>
                {{ $year }}
                </option>
                @endfor
               </select>

                @error('release_date')
                <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
               </div>
            </div>

            
        </div>
      </div>
    </form>
</div>

@endsection