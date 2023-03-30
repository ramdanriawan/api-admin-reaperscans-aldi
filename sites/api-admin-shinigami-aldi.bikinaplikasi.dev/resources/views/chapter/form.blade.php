<input type="hidden" name="komik_id" value="{{ request()->komik_id ?? ($chapter->komik_id ? $chapter->komik_id : "") }}">

<div class="form-group {{ $errors->has('tanggal_release') ? 'has-error' : ''}}">
    <label for="tanggal_release" class="control-label">{{ 'Tanggal Release' }}</label>

    <div class="col-md-12">
        <input placeholder="tanggal_release" class="form-control form-control-line @error('tanggal_release') is-invalid @enderror" name="tanggal_release"
               type="date" id="tanggal_release" value="{{ isset($chapter->tanggal_release) ? $chapter->tanggal_release : old('tanggal_release') }}" required>

        @error('tanggal_release')
        <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>

</div>


<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>

    <div class="col-md-12">
        <input placeholder="nama" class="form-control form-control-line @error('nama') is-invalid @enderror" name="nama"
               type="text" id="nama" value="{{ isset($chapter->nama) ? $chapter->nama : old('nama') }}" required>

        @error('nama')
        <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('gambar') ? 'has-error' : ''}}">
    <label for="gambar" class="control-label">{{ 'Gambar' }}</label>

    <div class="col-md-12">
        <input placeholder="gambar" class="form-control form-control-line @error('gambar') is-invalid @enderror" name="gambar"
               type="file" id="gambar" value="{{ isset($chapter->gambar) ? $chapter->gambar : old('gambar') }}"  accept="image/*">

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
