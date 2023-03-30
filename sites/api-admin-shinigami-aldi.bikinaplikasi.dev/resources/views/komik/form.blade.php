<div class="form-group {{ $errors->has('komik_tipe_id') ? 'has-error' : '' }}">
    <label for="komik_tipe_id" class="control-label">{{ 'Komik Tipe Id' }}</label>
{{-- 
    <a type="button" class="badge badge-primary" href="{{ route('tipe.create') }}">
        <i class="fa fa-plus"></i>
    </a> --}}

    <div class="col-md-12">

        <select name="komik_tipe_id" class="form-control form-control-line" id="komik_tipe_id" required>
            @foreach ($komik_tipe as $optionKey => $optionValue)
                <option value="{{ $optionKey }}"
                    {{ (isset($penjualan->komik_tipe_id) && $penjualan->komik_tipe_id == $optionKey) || old('komik_tipe_id') == $optionKey ? 'selected' : '' }}>
                    {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('komik_tipe_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('judul') ? 'has-error' : '' }}">
    <label for="judul" class="control-label">{{ 'Judul' }}</label>

    <div class="col-md-12">
        <input placeholder="judul" class="form-control form-control-line @error('judul') is-invalid @enderror"
            name="judul" type="text" id="judul"
            value="{{ isset($komik->judul) ? $komik->judul : old('judul') }}" required>

        @error('judul')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('sinopsis') ? 'has-error' : '' }}">
    <label for="sinopsis" class="control-label">{{ 'Sinopsis' }}</label>

    <div class="col-md-12">
        <textarea class="form-control" rows="5" name="sinopsis" type="textarea" id="sinopsis" placeholder="sinopsis">{{ isset($komik->sinopsis) ? $komik->sinopsis : old('sinopsis') }}</textarea>

        @error('sinopsis')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>


<div class="form-group {{ $errors->has('alternatif') ? 'has-error' : '' }}">
    <label for="alternatif" class="control-label">{{ 'Alternatif' }}</label>

    <div class="col-md-12">
        <input placeholder="alternatif" class="form-control form-control-line @error('alternatif') is-invalid @enderror"
            name="alternatif" type="text" id="alternatif"
            value="{{ isset($komik->alternatif) ? $komik->alternatif : old('alternatif') }}" required>

        @error('alternatif')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('author') ? 'has-error' : '' }}">
    <label for="author" class="control-label">{{ 'Author' }}</label>

    <div class="col-md-12">
        <input placeholder="author" class="form-control form-control-line @error('author') is-invalid @enderror"
            name="author" type="text" id="author"
            value="{{ isset($komik->author) ? $komik->author : old('author') }}" required>

        @error('author')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('artist') ? 'has-error' : '' }}">
    <label for="artist" class="control-label">{{ 'Artist' }}</label>

    <div class="col-md-12">
        <input placeholder="artist" class="form-control form-control-line @error('artist') is-invalid @enderror"
            name="artist" type="text" id="artist"
            value="{{ isset($komik->artist) ? $komik->artist : old('artist') }}" required>

        @error('artist')
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


<div class="form-group {{ $errors->has('genre') ? 'has-error' : '' }}">
    <label for="genre" class="control-label">{{ 'Genre' }}</label>

    <div class="col-md-12">
        @foreach ($komik_genre as $item)
            @if (isset($komik))
                @if (in_array($item->id, isset($komik) ? $komik->komik_list_genres->pluck('komik_genre_id')->toArray() : []))
                    <input type="checkbox" name="komik_list_genres[]" value="{{ $item->id }}" checked />
                    {{ $item->nama }}<br>
                @else
                <input type="checkbox" name="komik_list_genres[]" value="{{ $item->id }}" />
                {{ $item->nama }}<br>
                @endif
            @else
                <input type="checkbox" name="komik_list_genres[]" value="{{ $item->id }}" />
                {{ $item->nama }}<br>
            @endif
        @endforeach

        @error('genre')
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
