<select class="form-control" name="HocKy">
    @foreach ($hocky as $value)
    <option value="{{$value->HocKy}}"
    <?php if ($_POST['HocKy']==$value->HocKy):?>
        selected="selected"
        <?php endif ?>>
            {{$value->HocKy}}
    </option>;
    @endforeach
</select>