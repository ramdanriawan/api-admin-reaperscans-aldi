<div class="form-group {{ $errors->has('fullName') ? 'has-error' : ''}}">
    <label for="fullName" class="control-label">{{ 'fullName' }}</label>

    <div class="col-md-12">
        <input placeholder="fullName" class="form-control form-control-line @error('fullName') is-invalid @enderror" name="fullName"
               type="text" id="fullName" value="{{ isset($user->fullName) ? $user->fullName : old('fullName') }}" required>

        @error('fullName')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('jenisKelamin') ? 'has-error' : ''}}">
    <label for="jenisKelamin" class="control-label">{{ 'Jenis Kelamin' }}</label>

    <div class="col-md-12">

        <select name="jenisKelamin" class="form-control form-control-line" id="jenisKelamin" required>
            @foreach (['Laki - Laki','Perempuan'] as $optionKey => $optionValue)
                <option value="{{ $optionValue }}"
                    {{ (isset($user->jenisKelamin) && $user->jenisKelamin == $optionKey) || old('jenisKelamin') == $optionKey ? 'selected' : ''}}>
                    {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('jenisKelamin')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group {{ $errors->has('noHp') ? 'has-error' : ''}}">
    <label for="noHp" class="control-label">{{ 'noHp' }}</label>

    <div class="col-md-12">
        <input placeholder="noHp" class="form-control form-control-line @error('noHp') is-invalid @enderror" name="noHp"
               type="text" id="noHp" value="{{ isset($user->noHp) ? $user->noHp : old('noHp') }}" required>

        @error('noHp')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'email' }}</label>

    <div class="col-md-12">
        <input placeholder="email" class="form-control form-control-line @error('email') is-invalid @enderror" name="email"
               type="text" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" required>

        @error('email')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group {{ $errors->has('level') ? 'has-error' : ''}}">
    <label for="level" class="control-label">{{ 'Level' }}</label>

    <div class="col-md-12">

        <select name="level" class="form-control form-control-line" id="level" required>
            @foreach (['pendeta','jemaat'] as $optionKey => $optionValue)
                <option value="{{ $optionValue }}"
                    {{ (isset($user->level) && $user->level == $optionKey) || old('level') == $optionKey ? 'selected' : ''}}>
                    {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('level')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    <label for="alamat" class="control-label">{{ 'alamat' }}</label>

    <div class="col-md-12">
        <input placeholder="alamat" class="form-control form-control-line @error('alamat') is-invalid @enderror" name="alamat"
               type="text" id="alamat" value="{{ isset($user->alamat) ? $user->alamat : old('alamat') }}" required>

        @error('alamat')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>