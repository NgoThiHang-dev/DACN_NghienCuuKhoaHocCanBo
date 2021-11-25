@include('users.layout.index')
<body>
    @include('users.partials.header')
    <div id="container" style="margin: 10px auto; width: 600px">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header" style="background-color: #e35d6a; padding: 1rem!important; box-sizing: border-box; display: block;">
                                <h4 class="card-title w-100" style="text-align: center; text-transform: uppercase; color: #fff">
                                    Đổi mật khẩu
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form class="form-horizontal" method="POST" action="{{ asset('users/doimatkhau') }}">
                                    {{ csrf_field() }}
                                    @csrf
                                    <div
                                        class="mb-3 row form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="new-password" class="col-sm-4 col-form-label" style="font-weight: 100">Mật khẩu cũ</label>
                                        <div class="col-sm-8">
                                            <input id="current-password" type="password" class="form-control"
                                                name="current-password" required>

                                            @if ($errors->has('current-password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('current-password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div
                                        class="mb-3 row form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password" class="col-sm-4 col-form-label" style="font-weight: 100">Mật khẩu mới</label>
<div class="col-sm-8">
                                            <input id="new-password" type="password" class="form-control"
                                                name="new-password" required>

                                            @if ($errors->has('new-password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new-password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password-confirm" class="col-sm-4 col-form-label" style="font-weight: 100">Nhập lại mật
                                            khẩu</label>
                                        <div class="col-sm-8">
                                            <input id="new-password-confirm" type="password" class="form-control"
                                                name="new-password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4" style="float: right; width: 120px;">
                                            <button type="submit" class="btn " style="font-size: 15px; color: #fff; background-color: #28a745">
                                                Lưu mật khẩu
                                            </button>
                                        </div>
                                        {{--  <div class="col-md-6 col-md-offset-4" style="float: right; width: 60px;">
                                            <button type="submit" class="btn " style="font-size: 15px; color: #fff; background-color: #495057">
                                                Hủy
                                            </button>
                                        </div>  --}}
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>




                </div>
            </div>
        </div>
        <!-- /.content -->


    </div>
    @include('users.partials.footer')
</body>