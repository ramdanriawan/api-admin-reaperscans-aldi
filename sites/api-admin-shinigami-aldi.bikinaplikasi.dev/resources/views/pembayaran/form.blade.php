
<div class="form-group {{ $errors->has('jumlah') ? 'has-error' : ''}}">
    <label for="jumlah" class="control-label">{{ 'Jumlah' }}</label>

    <div class="col-md-12">
        <input placeholder="jumlah" class="form-control form-control-line @error('jumlah') is-invalid @enderror" name="jumlah"
               type="text" id="jumlah" value="{{ isset($pembayaran->jumlah) ? $pembayaran->jumlah : old('jumlah') }}" required>

        @error('jumlah')
        <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>

</div>


<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>

    <div class="col-md-12">

        <select name="status" class="form-control form-control-line" id="status" required>
            @foreach (['pending' => 'pending','selesai' => 'selesai','cancel' => 'cancel','refund' => 'refund'] as $optionKey => $optionValue)
                <option
                    value="{{ $optionKey }}" {{ (isset($penjualan->status) && $penjualan->status == $optionKey) || old('status') == $optionKey ? 'selected' : ''}}>{{ $optionValue }}</option>
            @endforeach
        </select>

        @error('status')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>


<div class="form-group {{ $errors->has('jumlah_bulan') ? 'has-error' : ''}}">
    <label for="jumlah_bulan" class="control-label">{{ 'Jumlah Bulan' }}</label>

    <div class="col-md-12">
        <input placeholder="jumlah_bulan" class="form-control form-control-line @error('jumlah_bulan') is-invalid @enderror" name="jumlah_bulan"
               type="text" id="jumlah_bulan" value="{{ isset($pembayaran->jumlah_bulan) ? $pembayaran->jumlah_bulan : old('jumlah_bulan') }}" required>

        @error('jumlah_bulan')
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
