<select class="form-control" name="HocKy">
    @foreach ($hocky as $value)
        <option value="{{ $value->HocKy }}">
            {{ $value->HocKy }}
        </option>;
    @endforeach
</select>