<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<h1>Edit User</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">

    @csrf
    @method('PUT')

    <p>
        <label>Nama</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
        >
    </p>

    <p>
        <label>Username</label><br>
        <input
            type="text"
            name="username"
            value="{{ old('username', $user->username) }}"
            required
        >
    </p>

    <p>
        <label>Email</label><br>
        <input
            type="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            required
        >
    </p>

    <p>
        <label>Password Baru</label><br>

        <input
            type="password"
            name="password"
        >

        <br>

        <small>
            Kosongkan jika password tidak ingin diganti.
        </small>
    </p>

    <p>
        <label>NIP</label><br>
        <input
            type="text"
            name="nip"
            value="{{ old('nip', $user->nip) }}"
            required
        >
    </p>

    <p>

        <label>Unit Kerja</label><br>

        <select name="unit_kerja_id" required>

            @foreach($unitKerja as $unit)

                <option
                    value="{{ $unit->id }}"
                    {{ old('unit_kerja_id', $user->unit_kerja_id) == $unit->id ? 'selected' : '' }}
                >
                    {{ $unit->nama_unit }}
                </option>

            @endforeach

        </select>

    </p>

    <p>

        <label>Jabatan</label><br>

        <select name="jabatan_id" required>

            @foreach($jabatan as $jab)

                <option
                    value="{{ $jab->id }}"
                    {{ old('jabatan_id', $user->jabatan_id) == $jab->id ? 'selected' : '' }}
                >
                    {{ $jab->nama_jabatan }}
                </option>

            @endforeach

        </select>

    </p>

    <p>

        <label>Role</label><br>

        <select name="role" required>

            @foreach($roles as $role)

                <option
                    value="{{ $role->name }}"
                    {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}
                >
                    {{ $role->name }}
                </option>

            @endforeach

        </select>

    </p>

    <p>

        <label>Status</label><br>

        <select name="is_active">

            <option
                value="1"
                {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}
            >
                Aktif
            </option>

            <option
                value="0"
                {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}
            >
                Non Aktif
            </option>

        </select>

    </p>

    <button type="submit">
        Update
    </button>

    <button type="reset">
        Reset
    </button>

    <a href="{{ route('users.index') }}">
        Kembali
    </a>

</form>

</body>
</html>