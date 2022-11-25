<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list_episode = Episode::with('movie')->OrderBy('movie_id','DESC')->get();

        // return response()->json($list_episode);

        return view('admincp.episode.index',compact('list_episode'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.episode.form',compact('list_movie'));
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
        $episode =  new Episode();
        $episode->movie_id = $data['movie_id'];
        $episode->link_phim = $data['link'];
        $episode->episode = $data['episode'];
        $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->save();
        return redirect()->back();
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
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');
        $episode = Episode::find($id);
        return view('admincp.episode.form',compact('list_movie','episode'));
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
        //
        $data = $request->all();
        $episode =  Episode::find($id);
        $episode->movie_id = $data['movie_id'];
        $episode->link_phim = $data['link'];
        $episode->episode = $data['episode'];
        $episode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->save();
        return redirect()->to('episode');
        // return redirect()->route('episode.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Episode::find($id)->delete();
        // return redirect()->back();
        $episode = Episode::find($id)->delete();
        return redirect()->to('episode');
    }
    public function select_movie(){
        $id = $_GET['id'];
        $movie__by_id = Movie::find($id);
        // echo $movie__by_id->sotap;
        $output = '<option>---Chọn tập phim---</option>';
        for($i=1;$i<=$movie__by_id->sotap;$i++){
            $output.= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $output;
    }
}
