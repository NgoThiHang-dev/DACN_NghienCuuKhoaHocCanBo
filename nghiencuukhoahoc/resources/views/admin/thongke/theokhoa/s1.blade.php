<select class="form-control" name="MaKhoa">
    <option value="">Chọn Khoa công tác</option>
    @foreach ($khoa as $value)
        
        <option value="{{ $value['MaKhoa'] }}">{{ $value['TenKhoa'] }}
        </option>;
    @endforeach
</select>
<p>Chưa có dữ liệu</p>