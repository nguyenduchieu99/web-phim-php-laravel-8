@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{route('movie.create')}}" class="btn btn-primary">Thêm phim</a>
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên phim</th>
                            <th scope="col">Từ khóa</th>
                            <th scope="col">Độ phân giải</th>
                            <th scope="col">Phụ đề</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Phim hot</th>
                            <th scope="col">Thời lượng</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thể loại</th>
                            <th scope="col">Quốc gia</th>
                            <th scope="col">Số tập</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Ngày cập nhập</th>
                            <th scope="col">View theo</th>
                            <th scope="col">Năm</th>
                            <th scope="col">Season</th>
                            <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $cate)
                            <tr>
                                <th scope="row">{{$key}}</th>
                                
                                <td>{{ $cate->title }}</td>

                                <td>
                                    @if($cate->tags!=NULL)
                                    {{substr($cate->tags,0,100)}}
                                    @else
                                    Chưa có từ khóa cho phim
                                    @endif
                                </td>

                                <td>
                                    @if ($cate->resolution==0)
                                        HD
                                    @elseif($cate->resolution==1)
                                        SD
                                    @elseif($cate->resolution==2)
                                        HDCam
                                    @elseif($cate->resolution==3)
                                        Cam  
                                    @elseif($cate->resolution==4)
                                        FullHD     
                                    @else
                                        Trailer       
                                    @endif
                                </td>

                                <td>
                                    @if ($cate->phude==0)
                                        Phụ đề
                                    @else
                                        Thuyết minh
                                    @endif
                                </td>

                                <td><img width="100" src="{{asset('uploads/movie/'.$cate->image)}}" ></td>


                                <td>
                                    @if ($cate->phim_hot==0)
                                        Không
                                    @else
                                        Có
                                    @endif
                                </td>

                                <td>{{ $cate->thoiluong }}</td>

                                <td>{{ $cate->slug }}</td>
                       
                                <td>
                                    @if ($cate->status)
                                        Hiển thị
                                    @else
                                        Không hiển thi
                                    @endif
                                </td>

                                <td>{{$cate->category->title}}</td>
                                
                                if()
                                <td>
                                    @foreach ($cate->movie_genre as $gen)
                                    <span class="badge bg-dark">{{$gen->title}}</span>
                                    @endforeach
                                </td>
                               

                                <td>{{$cate->country->title}}</td>
                                <td>{{$cate->sotap}}</td>
                                <td>{{$cate->ngaytao}}</td>
                                <td>{{$cate->ngaycapnhap}}</td>
                                <td>
                                    <form  method="POST">
                                        @csrf
                                        <select class="topview" name="topview123">

                                            @if ($cate->topview == 1)

                                            <option id="{{$cate->id}}" value="0">Ngày</option>
                                            <option selected id="{{$cate->id}}" value="1">Tuần</option>
                                            <option id="{{$cate->id}}" value="2">Tháng</option>
                                            <option id="{{$cate->id}}" value="3">Năm</option>
                                                
                                            @elseif($cate->topview == 2)

                                            <option id="{{$cate->id}}" value="0">Ngày</option>
                                            <option id="{{$cate->id}}" value="1">Tuần</option>
                                            <option selected id="{{$cate->id}}" value="2">Tháng</option>
                                            <option id="{{$cate->id}}" value="3">Năm</option>

                                            @elseif($cate->topview == 3)

                                            <option id="{{$cate->id}}" value="0">Ngày</option>
                                            <option id="{{$cate->id}}" value="1">Tuần</option>
                                            <option id="{{$cate->id}}" value="2">Tháng</option>
                                            <option selected id="{{$cate->id}}" value="3">Năm</option>
                                            
                                            @else

                                            <option selected id="{{$cate->id}}" value="0">Ngày</option>
                                            <option id="{{$cate->id}}" value="1">Tuần</option>
                                            <option id="{{$cate->id}}" value="2">Tháng</option>
                                            <option id="{{$cate->id}}" value="3">Năm</option>

                                            @endif
                                        </select>
                                    </form>
                                </td>
                                {{-- <td>
                                    {!! Form::select('topview', ['0' => 'Ngày', '1' => 'Tuần', '2' => 'Tháng'],isset($cate->topview) ? $cate->topview : '', [
                                        'class' => 'select-topview','id' => $cate->id ]) !!}
                                </td> --}}
                                {{-- <td>
                                    {!! Form::selectYear('year', 2000,2022,isset($cate->year) ? $cate->year : '', ['class'=>'select-year','id'=>$cate->id]) !!}
                                </td> --}}
                                
                                <td>
                                    <form method="POST">
                                        @csrf
                                        
                                        {!! Form::selectYear('year', 2000,2022,isset($cate->year) ? $cate->year : '', ['class'=>'select-year','id'=>$cate->id]) !!}
                                    </form>
                                   
                                </td>

                                <td>
                                    <form method="POST">
                                        @csrf
                                        
                                        {!! Form::selectRange('season', 0,20,isset($cate->season) ? $cate->season : '', ['class'=>'select-season','id'=>$cate->id]) !!}
                                    </form>
                                   
                                </td>

                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['movie.destroy', $cate->id],
                                        'onsubmit' => 'return confirm("Xóa không pro")',
                                    ]) !!}
                                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{ route('movie.edit', $cate->id) }}" class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

