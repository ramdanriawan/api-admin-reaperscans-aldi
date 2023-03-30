
<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
    <label for="link" class="control-label">{{ 'Link' }}</label>

    <div class="col-md-12">
        <input placeholder="link" class="form-control form-control-line @error('link') is-invalid @enderror"
            name="link" type="text" id="link"
            value="{{ isset($popup->link) ? $popup->link : old('link') }}" required>

        @error('link')
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
            value="{{ isset($popup->gambar) ? $popup->gambar : old('gambar') }}" accept="image/*">

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
