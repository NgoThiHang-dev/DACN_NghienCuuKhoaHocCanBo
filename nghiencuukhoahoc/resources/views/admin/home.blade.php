@extends('Admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('admin.partials.content-header', ['name'=>'Home', 'key'=>'Home'])
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h2 class="text-center display-4">Search</h2>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        {{-- <div class="header-search">
                            <form action="" id="header-search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="search" class="form-control form-control-lg" placeholder="Nhập từ khóa của bạn ở đây">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <div class="form-group">
                            <input type="text" name="TenGV" id="TenGV" class="form-control input-lg"
                                placeholder="Nhập từ khóa của bạn ở đây" />
                            <div id="countryList">
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </div>
                </div>

            </div>
        </section>

    </div>
    <script>
        $(document).ready(function() {

            $('#TenGV').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('home.fetch') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#countryList').fadeIn();
                            $('#countryList').html(data);
                        }
                    });
                }
            });

            $(document).on('click', 'li', function() {
                $('#TenGV').val($(this).text());
                $('#countryList').fadeOut();
            });

        });

    </script>


@endsection
