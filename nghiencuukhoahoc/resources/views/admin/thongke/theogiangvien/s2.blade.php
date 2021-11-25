<select class="form-control" name="MaGV">
    @foreach ($gv as $value)
    <option value="{{$value['MaGV']}}"
    <?php if ($_POST['MaGV']==$value['MaGV']):?>
        selected="selected"
        <?php endif ?>>
            {{$value['TenGV']}}
    </option>;
    @endforeach
</select>