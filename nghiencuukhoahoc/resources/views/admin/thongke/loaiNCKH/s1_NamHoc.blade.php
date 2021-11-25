<select class="form-control" name="NamHoc">
    @foreach ($namhoc as $value)
        <option value="{{ $value->NamHoc }}">
            {{ $value->NamHoc }}
        </option>;
    @endforeach
</select>