<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
</head>
<body>

<h1>Daftar User</h1>

@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

<!-- Tombol Tambah User -->
<p>
    <a href="{{ route('users.create') }}">
        <button type="button">
            + Tambah User
        </button>
    </a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Unit Kerja</th>
            <th>Jabatan</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    @forelse($users as $user)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $user->username }}</td>

            <td>{{ $user->name }}</td>

            <td>{{ $user->email }}</td>

            <td>{{ $user->unitKerja->nama_unit ?? '-' }}</td>

            <td>{{ $user->jabatan->nama_jabatan ?? '-' }}</td>

            <td>
                {{ $user->getRoleNames()->first() ?? '-' }}
            </td>

            <td>
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </td>

            <td>

                <a href="{{ route('users.edit', $user->id) }}">
                    Edit
                </a>

                |

                <form action="{{ route('users.destroy', $user->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Yakin ingin menghapus user ini?')">
                        Hapus
                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="9">
                Belum ada data user.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

</body>
</html>