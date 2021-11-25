<select class="form-control" name="NamHoc">
    @foreach ($namhoc as $value)
    <option value="{{$value->NamHoc}}"
    <?php if ($_POST['NamHoc']==$value->NamHoc):?>
        selected="selected"
        <?php endif ?>>
            {{$value->NamHoc}}
    </option>;
    @endforeach
</select>