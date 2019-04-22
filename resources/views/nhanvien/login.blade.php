@extends('layout/login')
@section('content')
    {{--<div align="center">--}}
        <h1 align="center">Đăng nhập hệ thống</h1>
        <?php
        if (isset($_SESSION['err_message'])){
            echo "<p style='color: red'  align = center>".$_SESSION['err_message']."</p>";
            unset($_SESSION['err_message']);
        }
        ?>
    <form class="form-horizontal" action="{{ route('nhanvien-authenticate') }}" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <div class="box-body">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Tên đăng nhập</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="txt_tendangnhap" id="tendangnhap" placeholder="Tên đăng nhập">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Mật khẩu</label>

                <div class="col-sm-10">
                    <input type="password" class="form-control" id="matkhau" name="txt_matkhau" placeholder="Mật khẩu">
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div>
            <button type="submit" class="btn btn-block btn-primary">Đăng nhập</button>
        </div>
        <!-- /.box-footer -->
    </form>
    {{--</div>--}}

@endsection
