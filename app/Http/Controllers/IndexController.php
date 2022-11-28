<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Movie_Genre;
use DB;

class IndexController extends Controller
{
    public function timkiem(){
        
        if (isset($_GET['search'])) {
            $search = $_GET['search'];

            $category = Category::orderBy('position','ASC')->where('status',1)->get();
            $country = Country::orderBy('id','DESC')->where('status',1)->get();
            $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
            $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
            $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

            $movie = Movie::where('title','LIKE','%'.$search.'%')->orderBy('ngaycapnhap','DESC')->paginate(10);

            return view('pages.search',compact('category','country','genre','search','movie','phimhot_sidebar','phimhot_trailer'));
        }
        else{
            return redirect()->to('/');
        }
    }

    public function home() {
        $phimhot = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->get();

        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $catogory_home = Category::with('movie')->orderBy('id','DESC')->where('status',1)->get();
        return view('pages.home',compact('category','country','genre','catogory_home','phimhot','phimhot_sidebar','phimhot_trailer'));
    }
    public function category($slug) {    
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $cate_slug = Category::where('slug',$slug)->first();
        $movie = Movie::where('category_id',$cate_slug->id)->orderBy('ngaycapnhap','DESC')->paginate(10);
        return view('pages.category',compact('category','country','genre','cate_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }

    public function year($year) {    
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $year = $year;
        // dd($year);
        $movie = Movie::where('year',$year)->orderBy('ngaycapnhap','DESC')->paginate(10);
        return view('pages.year',compact('category','country','genre','year','movie','phimhot_sidebar','phimhot_trailer'));
    }

    public function tag($tag){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();
        // dd($tag);

        $tag = $tag;
        $movie = Movie::where('tags','LIKE','%'.$tag.'%')->orderBy('ngaycapnhap','DESC')->paginate(10);
        return view('pages.tag',compact('category','country','genre','tag','movie','phimhot_sidebar','phimhot_trailer'));
    }

    public function genre($slug) {
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();
        $genre_slug = Genre::where('slug',$slug)->first();

        //lấy ra nhiều thể loại phim
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }

        // return response()->json($many_genre);
        $movie = Movie::whereIn('id',$many_genre)->orderBy('ngaycapnhap','DESC')->paginate(10);

        return view('pages.genre',compact('category','country','genre','genre_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }

    public function country($slug) {
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $country_slug = Country::where('slug',$slug)->first();
        $movie = Movie::where('country_id',$country_slug->id)->orderBy('ngaycapnhap','DESC')->paginate(10);

        return view('pages.country',compact('category','country','genre','country_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }

    public function movie($slug) {
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status','1')->first();

        $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();

        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(3)->get();

        $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();

        return view('pages.movie',compact('category','country','genre','movie','related','phimhot_sidebar','phimhot_trailer','episode','episode_tapdau'));
    }

    public function watch($slug,$tap) {
       
        

        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->where('status',1)->get();

        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('3')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('10')->get();

        $movie = Movie::with('category','genre','country','movie_genre','episode')->where('slug',$slug)->where('status','1')->first();

       
        // return response()->json($movie);
        
        if (isset($tap)) {
            $tap_phim = $tap;
            $tap_phim = substr($tap,4,1);
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tap_phim)->first();
        } else {
            $tap_phim = 1;
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tap_phim)->first();
        }
        
        // dd($tap_phim);
        return view('pages.watch',compact('episode','category','country','genre','movie','phimhot_sidebar','phimhot_trailer','tap_phim'));
    }

    public function episode() {
        return view('pages.episode');
    }
}
