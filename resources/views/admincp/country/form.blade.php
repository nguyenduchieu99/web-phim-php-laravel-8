@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Quản lý quốc gia</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!isset($country))
                            {!! Form::open(['route' => 'country.store', 'method' => 'POST']) !!}
                        @else
                             {!! Form::open(['route' =>['country.update',$country->id]  ,'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($country) ? $country->title : '' , [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập dữ liệu...........',
                                'id' => 'slug', 'onkeyup'=>'ChangeToSlug()'
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($country) ? $country->slug : '' , [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập dữ liệu...........',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description ', 'Description ', []) !!}
                            {!! Form::textarea('description', isset($country) ? $country->description : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Nhập dữ liệu...........',
                                'id' => 'description',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status', []) !!}
                            {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($country) ? $country->status : '', ['class' => 'form-control']) !!}
                        </div>

                        @if (!isset($country))
                            {!! Form::submit('Thêm dữ liệu ', ['class' => 'btn btn-success']) !!}   
                        @else
                            {!! Form::submit('Cập nhập dữ liệu ', ['class' => 'btn btn-success']) !!}   
                        @endif
                            {!! Form::close() !!}
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th scope="col">Active/Inactive</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $country)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $country->title}}</td>
                                <td>{{ $country->slug}}</td>
                                <td>{{ $country->description}}</td>
                                <td>
                                    @if ($country->status)
                                        Hiển thị
                                    @else
                                        Không hiển thị
                                    @endif
                                </td>
                                <td>
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'route'=>['country.destroy',$country->id],
                                        'onsubmit'=>'return confirm("Xóa hay không")'
                                    ]) !!}
                                    {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{route('country.edit',$country->id)}}" class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
