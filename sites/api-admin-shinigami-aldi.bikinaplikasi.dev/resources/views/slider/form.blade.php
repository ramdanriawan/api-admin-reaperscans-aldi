<div class="form-group {{ $errors->has('komik_id') ? 'has-error' : '' }}">
    <label for="komik_id" class="control-label">{{ 'Komik Id' }}</label>

    <a type="button" class="badge badge-primary" href="{{ route('komik.create') }}">
        <i class="fa fa-plus"></i>
    </a>

    <div class="col-md-12">

        <select name="komik_id" class="form-control form-control-line" id="komik_id" required>
            @foreach ($komik as $optionKey => $optionValue)
                <option value="{{ $optionKey }}"
                    {{ (isset($slider->komik_id) && $slider->komik_id == $optionKey) || old('komik_id') == $optionKey || $optionKey == request()->komik_id ? 'selected' : '' }}>
                    {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('komik_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('gambar') ? 'has-error' : '' }}">
    <label for="gambar" class="control-label">{{ 'Gambar' }}</label>

    <div class="col-md-12">
        <input placeholder="gambar" class="form-control form-control-line @error('gambar') is-invalid @enderror"
            name="gambar" type="file" id="gambar"
            value="{{ isset($komik->gambar) ? $komik->gambar : old('gambar') }}" accept="image/*">

        @error('gambar')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group">
    <div class="col-sm-12">
        <button class="btn btn-success" type="submit">Simpan</button>
    </div>
</div>
