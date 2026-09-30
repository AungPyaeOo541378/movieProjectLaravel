@extends('layout.master')

@section('content')

<div class="container bg-dark-blue-gradient">
    <div class="row">
      
      <!--left column create movie list-->
      <div class="col-4 mt-5">
        <form action="{{ route('createMovie') }}" method="post" enctype="multipart/form-data">
            @csrf 
       
            <div> 
                <img src="{{asset('movieImages/default.Img.webp')}}" alt="" id="output" class="thumbnail w-50 h-50">
                <input type="file" name="image" id="image" class="form-control mt-2 @error('image') is-invalid @enderror" onchange="previewImage(event)">
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
               <div class=" mt-2">
                <input type="radio" name="image_type" class="form-check-input @error('image_type') is-invalid @enderror" value="poster" {{old('image_type') == 'poster' ? 'checked' : ''}} id="">
                <label for="" class="text-white">{{ __('messages.poster') }}</label>
              
                <input type="radio" name="image_type" class="form-check-input ms-2 @error('image_type') is-invalid @enderror" value="mainImage" {{old('image_type') == 'mainImage' ? 'checked' : ''}} id="">
                <label for="" class="text-white">{{ __('messages.movie_image') }}</label>

                 @error('image_type')
               <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
               </span>
               @enderror
               </div>
              

            </div>
            <div>
                <input type="text" name="title" placeholder="{{ __('messages.title') }}" value="{{old('title')}}" class="form-control mt-2 @error('title') is-invalid @enderror"/>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
                <textarea name="description" rows="5" class="form-control mt-2 @error('description') is-invalid @enderror" placeholder="{{ __('messages.description') }}">{{old('description')}}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
                 <select name="movie_type" id="" class="form-control mt-2 @error('movie_type') is-invalid @enderror">
                    <option value="" {{ old('movie_type') == "" ? "selected" : "" }}>{{ __('messages.select_movie_type') }}</option>
                    <option value="Action" {{ old('movie_type') == "Action" ? "selected" : "" }}>{{ __('messages.genre_action') }}</option>
                    <option value="Superhero" {{ old('movie_type') == "Superhero" ? "selected" : "" }}>{{ __('messages.genre_superhero') }}</option>
                    <option value="Horror" {{ old('movie_type') == "Horror" ? "selected" : "" }}>{{ __('messages.genre_horror') }}</option>
                    <option value="Anime" {{ old('movie_type') == "Anime" ? "selected" : "" }}>{{ __('messages.genre_anime') }}</option>
                    <option value="Romance" {{ old('movie_type') == "Romance" ? "selected" : "" }}>{{ __('messages.genre_romance') }}</option>
                    <option value="Drama" {{ old('movie_type') == "Drama" ? "selected" : "" }}>{{ __('messages.genre_drama') }}</option>
                 </select>
                 @error('movie_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
                <input type="text" name="director" value="{{old('director')}}" class="form-control mt-2 @error('director') is-invalid @enderror" placeholder="{{ __('messages.director') }}"/>
                @error('director')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
               <select name="rating" class="form-select mt-2 @error('rating') is-invalid @enderror">
                 <option value="">{{ __('messages.select_rating') }}</option>
                 @for($i = 1; $i <= 10; $i++)
                 <option value="{{ $i }}" {{ old('rating') == (string)$i ? 'selected' : '' }}>{{ $i }} {{ __('messages.stars') }}</option>
                 @endfor
               </select>
                 @error('rating')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
                <input type="text" name="duration" value="{{old('duration')}}" class="form-control mt-2 @error('duration') is-invalid @enderror" placeholder="{{ __('messages.duration_placeholder') }}"/>
                @error('duration')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div>
               <div class="mt-2">
               <select name="release_date" class="form-select @error('release_date') is-invalid @enderror">
                <option value="">{{ __('messages.select_release_year') }}</option>
                @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ old('release_date') == $year ? 'selected' : '' }}>
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
            <div>
                <input type="submit" value="{{ __('messages.create') }}" class="btn btn-primary mt-2">
            </div>
        </form>
      </div>

      <!--right column show movie list-->
      <div class="col-8 mt-5">
        <label for="" class="text-white fw-bold fs-2">{{ __('messages.admin_side') }}</label><hr>
        {{$movies->links()}} 
        
       <div class="row">
        
             @foreach ($movies as $item)
       <div class="col-6 mt-5">
         <div class="card h-100 shadow-sm mb-3" style="max-width: 540px;height:250px">
           <div class="row g-0 h-100">
             <div class="col-md-4">
                <img src="{{ asset('movieImages/' . $item->image) }}" class="img-fluid rounded-start m-2" alt="...">
             </div>
             <div class="col-md-8 d-flex flex-column justify-content-between ">
                <div class="card-body">
                  <h5 class="card-title">{{$item->title}}</h5>
                  <p class="badge bg-warning">
                    @if ($item->image_type == 'poster')
                      {{ __('messages.poster') }}
                    @else
                      {{ __('messages.movie_image') }}
                    @endif
                  </p>
                  <p class="card-text">{{ __('messages.rating') }}: {{$item->rating}} {{ __('messages.stars') }}</p>
                  
                  <div class="d-flex card-footer bg-transparent border-0 pb-3 mt-auto">
                    <div class="d-flex justify-content-between gap-1">
                     <a href="{{ route('details',$item->id)}}" class="btn btn-dark">{{ __('messages.movie_details') }}</a>
                     <a href="{{route('updatePage',$item->id)}}" class="btn btn-primary">{{ __('messages.update') }}</a>
                     <a href="{{ route('deleteMovie',$item->id) }}" class="btn btn-danger"><i class="fa-solid fa-trash" style="color: rgba(199, 197, 216, 1);"></i></a>
                    </div>
                  </div>
                </div>
             </div>
           </div>
        </div>
       </div>
        @endforeach
       </div>
      </div>

</div>

@endsection
