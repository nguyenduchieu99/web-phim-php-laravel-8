<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie_Genre;
use Carbon\Carbon;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category', 'country', 'movie_genre','genre')->orderBy('id', 'DESC')->get();
        //with('category) là tên hàm lấy ở bên movie
        // return response()->json($list);

        $path = public_path()."/json/";

        if(!is_dir($path)){
            mkdir($path,0777,true);
        }

        File::put($path.'movies.json',json_encode($list));
        return view('admincp.movie.index', compact('list'));
    }

    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['option_topview123'];
        $movie->save();
    }

    public function filter_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', $data['value'])->orderBy('ngaycapnhap', 'DESC')->take(10)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HD Cam';
            }elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'Full HD';
            }
             else {
                $text = 'Trailer';
            }


            $output .= '<div class="item">
        <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
           <div class="item-link">
              <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . 'Ử" title="' . $mov->title . '" />
              <span class="is_trailer">' . $text . '</span>
           </div>
           <p class="title">' . $mov->title . '</p>
        </a>
        <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
        <div style="float: left;">
           <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
           <span style="width: 0%"></span>
           </span>
        </div>
     </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhap', 'DESC')->take(10)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HD Cam';
            }elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'Full HD';
            }
             else {
                $text = 'Trailer';
            }

            $output .= '<div class="item">
        <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
           <div class="item-link">
              <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . 'Ử" title="' . $mov->title . '" />
              <span class="is_trailer">' . $text . '</span>
           </div>
           <p class="title">' . $mov->title . '</p>
        </a>
        <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
        <div style="float: left;">
           <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
           <span style="width: 0%"></span>
           </span>
        </div>
     </div>';
        }
        echo $output;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_movie = Category::pluck('title', 'id');
        $genre_movie = Genre::pluck('title', 'id');
        $country_movie = Country::pluck('title', 'id');
        $list_genre = Genre::all();
        $list = Movie::with('category', 'country', 'genre')->orderBy('id', 'DESC')->get();
        //with('category) là tên hàm lấy ở bên movie
        return view('admincp.movie.form', compact('category_movie', 'genre_movie','list_genre','country_movie'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->slug = $data['slug'];
        $movie->tags = $data['tags'];
        $movie->trailer = $data['trailer'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->phude = $data['phude'];
        $movie->sotap = $data['sotap'];
        // $movie->year = $data['year'];
        $movie->resolution = $data['resolution'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');

        foreach ($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }

        // $movie->genre_id = $data['genre_id'];
        //hỉnh ảnh

        $get_image = $request->file('image');

        if ($get_image) {

            $get_name_image = $get_image->getClientOriginalName(); //hinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //tách tên ảnh bằng dấu . =>[0]=> hinhanh,[1]=>jpg.hàm curent lấy tên hình ảnh
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //thêm nhiều thể loại cho phim
        $movie->movie_genre()->attach($data['genre']);
        
        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_movie = Category::pluck('title', 'id');
        $genre_movie = Genre::pluck('title', 'id');
        $country_movie = Country::pluck('title', 'id');
        $movie = Movie::find($id);
        $list_genre = Genre::all();
        $movie_genre = $movie->movie_genre;

        return view('admincp.movie.form', compact('category_movie','genre_movie','country_movie','list_genre','movie','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
         $movie->trailer = $data['trailer'];
        $movie->slug = $data['slug'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->phude = $data['phude'];
        $movie->sotap = $data['sotap'];
        // $movie->year = $data['year'];
        $movie->resolution = $data['resolution'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        // $movie->genre_id = $data['genre_id'];
        $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');

        foreach ($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }


        //hỉnh ảnh

        $get_image = $request->file('image');

        if ($get_image) {
            if (file_exists('uploads/movie/' . $movie->image)) {
                unlink('uploads/movie/' . $movie->image);
            } else {
                $get_name_image = $get_image->getClientOriginalName(); //hinhanh.jpg
                $name_image = current(explode('.', $get_name_image)); //tách tên ảnh bằng dấu . =>[0]=> hinhanh,[1]=>jpg.hàm curent lấy tên hình ảnh
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('uploads/movie/', $new_image);
                $movie->image = $new_image;
            }
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);
        
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        //xóa ảnh
        if (file_exists('uploads/movie/' . $movie->image)) {
            unlink('uploads/movie/' . $movie->image);
        }
        //xóa thể loại
        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
        
        $movie->delete();
        return redirect()->back();
    }
}
