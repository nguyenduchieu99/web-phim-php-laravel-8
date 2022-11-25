@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{route('episode.create')}}" class="btn btn-primary">Thêm phim</a>
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên phim</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tập phim</th>
                            <th scope="col">Link phim</th>
                            <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_episode as $key => $epi)
                            <tr>
                                <th scope="row">{{$key}}</th>
                                <td >{{$epi->movie->title}}</td>
                                <td><img width="100" src="{{asset('uploads/movie/'.$epi->movie->image)}}" ></td>
                                <td >{{$epi->episode}}</td>
                                <td >{!! $epi->link_phim !!}</td>
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['episode.destroy', $epi->id],
                                        'onsubmit' => 'return confirm("Xóa không pro")',
                                    ]) !!}
                                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{ route('episode.edit', $epi->id) }}" class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

