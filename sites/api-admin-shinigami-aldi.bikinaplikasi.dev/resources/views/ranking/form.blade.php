<div class="form-group {{ $errors->has('komik_id') ? 'has-error' : '' }}">
    <label for="komik_id" class="control-label">{{ 'Input List Komik id (Pisahkan dengan koma)' }}</label>

    <div class="col-md-12">
        <input placeholder="komik_id" class="form-control form-control-line @error('komik_id') is-invalid @enderror"
            name="komik_id" type="text" id="komik_id"
            value="{{ $komik_ranking_ids ?? "" }}" accept="image/*">

        @error('komik_id')
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
