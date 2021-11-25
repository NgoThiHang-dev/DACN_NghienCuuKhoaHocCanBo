<form action="" method="POST" style="width: 100%;" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{--  <div class="col ">
            <p>Từ ngày:<input type="date" id="datepicker" class="form-control" name="Tu" value="<?php echo @$_POST['Tu'];?>"></p>
        </div>
        <div class="col ">
            <p>Đến ngày:<input type="date" id="datepicker2" class="form-control" name="Den" value="<?php echo @$_POST['Den'];?>"></p>
        </div>  --}}
        <div class="col ">
            <p>Chọn Học kỳ:
                @if (isset($_POST['TK']))
                    @include('admin.thongke.loaiNCKH.s2_HocKy')
                @else
                    @include('admin.thongke.loaiNCKH.s1_HocKy')
                @endif
            </p>
        </div>
        <div class="col ">
            <p>Chọn Năm học:
                @if (isset($_POST['TK']))
                    @include('admin.thongke.loaiNCKH.s2_Namhoc')
                @else
                    @include('admin.thongke.loaiNCKH.s1_Namhoc')
                @endif
            </p>
        </div>
        <div class="col ">
            <p>Lọc theo
                <select class="dashboad-filter form-control" name="Loc">
                    <?php if (isset($_POST['TK'])) {
                    if (@$_POST['Loc'] == "") {
                    echo '<option value="" selected>Tất cả</option>
                    <optgroup label="Theo loại nghiên cứu">
                        <option value="DT">Đề tài NCKH</option>
                        <option value="BB">Bài báo</option>
                        <option value="TL">Sách, giáo trình, tài liệu giảng dạy</option>
                        <option value="HD">Các hoạt động NCKH khác</option>
                    </optgroup>';
                    }
                    if (@$_POST['Loc'] == 'DT') {
                    echo '<option value="">Tất cả</option>
                    <optgroup label="Theo loại nghiên cứu">
                        <option value="DT" selected>Đề tài NCKH</option>
                        <option value="BB">Bài báo</option>
                        <option value="TL">Sách, giáo trình, tài liệu giảng dạy</option>
                        <option value="HD">Các hoạt động NCKH khác</option>
                    </optgroup>';
                    }
                    if (@$_POST['Loc'] == 'BB') {
                    echo '<option value="">Tất cả</option>
                    <optgroup label="Theo loại nghiên cứu">
                        <option value="DT">Đề tài NCKH</option>
                        <option value="BB" selected>Bài báo</option>
                        <option value="TL">Sách, giáo trình, tài liệu giảng dạy</option>
                        <option value="HD">Các hoạt động NCKH khác</option>
                    </optgroup>';
                    }
                    if (@$_POST['Loc'] == 'TL') {
                    echo '<option value="">Tất cả</option>
                    <optgroup label="Theo loại nghiên cứu">
                        <option value="DT">Đề tài NCKH</option>
                        <option value="BB">Bài báo</option>
                        <option value="TL" selected>Sách, giáo trình, tài liệu giảng dạy</option>
                        <option value="HD">Các hoạt động NCKH khác</option>
                    </optgroup>';
                    }
                    if (@$_POST['Loc'] == 'HD') {
                        echo '<option value="">Tất cả</option>
                        <optgroup label="Theo loại nghiên cứu">
                            <option value="DT">Đề tài NCKH</option>
                            <option value="BB">Bài báo</option>
                            <option value="TL">Sách, giáo trình, tài liệu giảng dạy</option>
                            <option value="HD" selected>Các hoạt động NCKH khác</option>
                        </optgroup>';
                        }
                    } else {
                    echo ' <option value="">Tất cả</option>
                    <optgroup label="Theo loại nghiên cứu">
                        <option value="DT">Đề tài NCKH</option>
                        <option value="BB">Bài báo</option>
                        <option value="TL">Sách, giáo trình, tài liệu giảng dạy</option>
                        <option value="HD">Các hoạt động NCKH khác</option>
                    </optgroup>';
                    } ?>
                </select>

            </p>
        </div>
        <div class="col">
            <br>
            <input type="submit" style="height: 36px" class="btn btn-primary btn-sm" value="Lọc kết quả"
                name="TK">
            
        </div>
    </div>
</form>