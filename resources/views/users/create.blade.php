<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
</head>
<body>

<h1>Tambah User</h1>

<form action="{{ route('users.store') }}" method="POST">

    @csrf

    <p>
        <label>Nama</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>

        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </p>

    <p>
        <label>Username</label><br>
        <input type="text" name="username" value="{{ old('username') }}" required>

        @error('username')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </p>

    <p>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required>

        @error('email')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>

        @error('password')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </p>

    <p>
        <label>NIP</label><br>
        <input type="text" name="nip" value="{{ old('nip') }}" required>

        @error('nip')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </p>

    <p>
        <label>Unit Kerja</label><br>

        <select name="unit_kerja_id" required>

            <option value="">-- Pilih Unit Kerja --</option>

            @foreach($unitKerja as $unit)

                <option value="{{ $unit->id }}"
                    {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>

                    {{ $unit->nama_unit }}

                </option>

            @endforeach

        </select>

        @error('unit_kerja_id')
            <small style="color:red">{{ $message }}</small>
        @enderror

    </p>

    <p>
        <label>Jabatan</label><br>

        <select name="jabatan_id" required>

            <option value="">-- Pilih Jabatan --</option>

            @foreach($jabatan as $jab)

                <option value="{{ $jab->id }}"
                    {{ old('jabatan_id') == $jab->id ? 'selected' : '' }}>

                    {{ $jab->nama_jabatan }}

                </option>

            @endforeach

        </select>

        @error('jabatan_id')
            <small style="color:red">{{ $message }}</small>
        @enderror

    </p>

    <p>
        <label>Role</label><br>

        <select name="role" required>

            <option value="">-- Pilih Role --</option>

            @foreach($roles as $role)

                <option value="{{ $role->name }}"
                    {{ old('role') == $role->name ? 'selected' : '' }}>

                    {{ $role->name }}

                </option>

            @endforeach

        </select>

        @error('role')
            <small style="color:red">{{ $message }}</small>
        @enderror

    </p>

    <p>
        <label>Status</label><br>

        <select name="is_active">

            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                Non Aktif
            </option>

        </select>

    </p>

    <button type="submit">
        Simpan
    </button>

    <a href="{{ route('users.index') }}">
        Kembali
    </a>

</form>

</body>
</html>