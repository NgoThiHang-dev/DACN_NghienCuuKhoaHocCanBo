<select class="form-control" name="MaKhoa">
    @foreach ($khoa as $value)
    <option value="{{$value['MaKhoa']}}"
    <?php if ($_POST['MaKhoa']==$value['MaKhoa']):?>
        selected="selected"
        <?php endif ?>>
            {{$value['TenKhoa']}}
    </option>;
@endforeach
</select>