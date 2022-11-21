<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            {{-- </div> --}}
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if (Auth::id())
                @include('layouts.navbar')
            @endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $('.select-movie').change(function(){
            var id = $(this).val();
            $.ajax({
                url: "{{route('select-movie')}}",
                method: "GET",
                data: {
                    id:id,
                },
                success: function(data) {
                    $('#episode').html(data);
                }
            });
        })
    </script>
    
    {{-- Year --}}
    <script type="text/javascript">
        $('.select-year').change(function() {
            var year = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            // alert(year);
            // alert(id_phim);
            // alert(_token);
            $.ajax({
                url: "{{ url('/update-year-phim') }}",
                method: "POST",
                data: {
                    year:year,
                    id_phim: id_phim,
                    _token:_token
                },
                success: function() {
                    alert('Thay đổi phim năm ' + year + ' thành công');
                }
            });
        })
    </script>

       {{-- season --}}
       <script type="text/javascript">
        $('.select-season').change(function() {
            var season = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ url('/update-season-phim') }}",
                method: "POST",
                data: {
                    season:season,
                    id_phim: id_phim,
                    _token:_token
                },
                success: function() {
                    alert('Thay đổi phim season ' + season + ' thành công');
                }
            });
        })
    </script>

    {{-- Topview --}}
    <script type="text/javascript">
        $('.topview').change(function() {
            var option_topview = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
         
            if(option_topview == 1){
                var text = 'Tuần';
            }else if(option_topview == 2){
                var text = 'Tháng';
            }else {
                var text = 'Năm';
            }
            //    alert(option_topview);
            // alert(id_phim);
            // alert(_token);
            // alert(text);
           
            $.ajax({
                url: "{{url('/update-topview-phim')}}",
                method: "POST",
                data: {
                    option_topview:option_topview,
                    id_phim: id_phim,
                    _token:_token
                },
                success: function() {
                    alert('Thay đổi phim năm ' + text + ' thành công');
                }
            });
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablephim').DataTable();
        });

        function ChangeToSlug() {

            var slug;

            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
    <script type="text/javascript">
        $('.order_position').sortable({
            placeholder: 'ui-state-highlight', //khi keo thì hiển thị sáng lên
            //thực hiệp update bằng ijax
            update: function(event, ui) {
                var array_id = [];
                $('.order_position tr').each(function() {
                    //từ clas order_position đi xuống thẻ tr...each(functiin) lấy đừng cái xong đẩy vào đó
                    array_id.push($(this).attr('id'));
                })
                //lấy 1 chuỗi id từng cái id của thằng category
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('resorting') }}",
                    method: "POST",
                    data: {
                        array_id: array_id
                    },
                    success: function(data) {
                        alert('sắp xếp thứ tự thành công');
                    }
                })
            }
        })
    </script>
</body>

</html>
