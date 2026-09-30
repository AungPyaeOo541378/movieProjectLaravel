<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function changeLanguage($lang)
    {
        if (in_array($lang, ['en', 'ja'])) {
            session()->put('locale', $lang);
        }
        return back();
    }

    public function movieList()
    {
         $movies=Movie::select('id','title','image','image_type','movie_type','description','director','rating','duration','release_date')
         ->orderBy('id','desc')
         ->paginate(4);
        return view('admin.movieList',compact('movies'));
    }

    // User Search (Supports hyphens, spaces & typos like "onepice" -> "One-Piece")
    public function search(Request $request)
    {
        $rawSearch = trim($request->search);
        
        // Remove hyphens, spaces, and special characters from search input (e.g. "One-Piece" / "onepice" -> "onepice")
        $cleanSearch = preg_replace('/[^a-zA-Z0-9]/', '', $rawSearch);
        
        // Split search input into words
        $words = explode(' ', $rawSearch);

        $movies = Movie::where(function ($query) use ($rawSearch, $cleanSearch, $words) {
            // 1. Direct match (e.g. "One-Piece")
            $query->where('title', 'like', '%' . $rawSearch . '%');

            // 2. Ignore hyphens and spaces in database title (e.g. "One-Piece" matches "onepice", "onepiece", "one piece")
            if (!empty($cleanSearch)) {
                $query->orWhereRaw("REPLACE(REPLACE(REPLACE(title, '-', ''), ' ', ''), '_', '') LIKE ?", ['%' . $cleanSearch . '%']);
            }

            // 3. Match individual words (e.g. "One", "Piece")
            foreach ($words as $word) {
                if (strlen($word) >= 2) {
                    $query->orWhere('title', 'like', '%' . $word . '%');
                }
            }

            // 4. Handle minor typos (e.g. search first 3+ letters like "one" from "onepice")
            if (strlen($cleanSearch) >= 3) {
                $prefix = substr($cleanSearch, 0, 3);
                $query->orWhere('title', 'like', '%' . $prefix . '%');
            }
        })
        ->orderBy('id', 'desc')
        ->paginate(6);

        return view('user.userSearch', compact('movies'));
    }


    //user forshow section
    public function userShowMainPage()
    {
        $poster=Movie::select('id','title','image','image_type','movie_type','description','director','rating','duration','release_date')
         ->where('image_type','poster')
         ->orderBy('id','desc')
         ->get();

        $mainImage=Movie::select('id','title','image','image_type','movie_type','description','director','rating','duration','release_date')
         ->where('image_type','mainImage')
         ->orderBy('id','desc')
         ->get();
         
         return view('user.userShowMainPage',compact('poster','mainImage'));
    }

    //user show Details
    public function userShowDetails($id)
    {
        $movie=Movie::find($id);
        return view('user.userDetails',compact('movie'));
    }

    //create Movie
    public function createMovie(Request $request)
    {
        $this->MovieValidation($request,'create');
        $data=$this->RequestMovieData($request);
        
        
        if($request->hasFile('image')){
            $imageName=uniqid() .":aungpyae:". $request->image->getClientOriginalName();
            $request->file('image')->move(public_path('/movieImages/'),$imageName);
            $data['image']=$imageName;
            
        }
         Movie::create($data);
         return back();

      
    }

    //delete Movie
    public function deleteMovie($id)
    {
       $movie=Movie::find($id);
       $oldImage=$movie->image;
        //if has image ,delete it
        if(file_exists(public_path('/movieImages/'. $oldImage))){
            unlink(public_path('/movieImages/'. $oldImage));
        }
        

        Movie::where('id',$id)->delete();
        return back();
    }

    //details
    public function details($id)
    {
        $movie=Movie::find($id);
        return view('admin.details',compact('movie'));
    }

    //updatePage
    public function updatePage($id)
    {
       $data=Movie::find($id);
       return view('admin.updatePage',compact('data'));
    }

    //update
    public function update(Request $request)
    {
        $this->MovieValidation($request, 'update');
        $data = $this->RequestMovieData($request);
        $oldImage = $request->old_image;

        if ($request->hasFile('image')) {
            // Delete old photo if it exists
            if ($oldImage && file_exists(public_path('/movieImages/' . $oldImage))) {
                unlink(public_path('/movieImages/' . $oldImage));
            }
            // Save new photo
            $newImageName = uniqid() . ":aungpyae:" . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('/movieImages/'), $newImageName);

            $data['image'] = $newImageName;
        } else {
            $data['image'] = $oldImage;
        }

        Movie::where('id', $request->id)->update($data);
        return redirect()->route('adminMovieList');
    }

   

    
    //validation
    private function MovieValidation($request,$action){

      
        $validationRules=[
            
            'image_type'=> 'required|in:poster,mainImage',
            'title'=>'required|unique:movies,title,'.$request->id,
            'description'=>'required',
            'movie_type'=>'required',
            'director'=>'required',
            'rating'=>'required|in:1,2,3,4,5,6,7,8,9,10',
            'duration'=>'required|numeric|between:60,300',
            'release_date'=>'required',
        ];
        $validationRules['image']= $action == "create"?'required|mimes:jpg,png,jpeg,gif,svg|max:2048':'mimes:jpg,png,jpeg,gif,svg|max:2048';
        $validationMessages=[
            'image.required'=> __('messages.val_image_required'),
            'image.mimes'=> __('messages.val_image_mimes'),
            'image.max'=> __('messages.val_image_max'),
            'image_type.required'=> __('messages.val_image_type_required'),
            'image_type.in'=> __('messages.val_image_type_in'),
            'title.required'=> __('messages.val_title_required'),
            'title.unique'=> __('messages.val_title_unique'),
            'description.required'=> __('messages.val_description_required'),
            'movie_type.required'=> __('messages.val_movie_type_required'),
            'director.required'=> __('messages.val_director_required'),
            'rating.required'=> __('messages.val_rating_required'),
            'duration.required'=> __('messages.val_duration_required'),
            'duration.numeric'=> __('messages.val_duration_numeric'),
            'duration.between'=> __('messages.val_duration_between'),
            'release_date.required'=> __('messages.val_release_date_required'),
        ];
        $request->validate($validationRules,$validationMessages);
    }
    
    //Request Data
    private function RequestMovieData($request)
    {
        return
        [
            'title'=>$request->title,
            'image_type'=>$request->image_type,
            'description'=>$request->description,
            'movie_type'=>$request->movie_type,
            'director'=>$request->director,
            'rating'=>$request->rating,
            'duration'=>$request->duration,
            'release_date'=>$request->release_date,
        ];
    }
}
