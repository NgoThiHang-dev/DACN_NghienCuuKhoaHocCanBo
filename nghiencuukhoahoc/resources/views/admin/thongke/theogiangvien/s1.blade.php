<select class="form-control" name="MaGV">
    <option value="">Chọn tác giả</option>
    @foreach ($gv as $value)
        <option value="{{ $value['MaGV'] }}">
            {{ $value['TenGV'] }}
        </option>;
    @endforeach
</select>
<p>Chưa có dữ liệu</p>