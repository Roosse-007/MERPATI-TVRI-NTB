<!DOCTYPE html>
<html>
<head>
    <title>Data Jabatan</title>
</head>

<body>

<h1>Data Jabatan</h1>


@if(session('success'))

<p style="color:green">
    {{ session('success') }}
</p>

@endif



<a href="{{ route('jabatan.create') }}">
    + Tambah Jabatan
</a>


<br><br>


<table border="1" cellpadding="8">

<thead>

<tr>
    <th>No</th>
    <th>Nama Jabatan</th>
    <th>Aksi</th>
</tr>

</thead>


<tbody>

@forelse($jabatan as $jab)


<tr>

<td>
    {{ $loop->iteration }}
</td>


<td>
    {{ $jab->nama_jabatan }}
</td>


<td>

<a href="{{ route('jabatan.edit', $jab->id) }}">
    Edit
</a>


|


<form action="{{ route('jabatan.destroy', $jab->id) }}"
      method="POST"
      style="display:inline">

    @csrf
    @method('DELETE')


    <button type="submit"
        onclick="return confirm('Hapus jabatan ini?')">

        Hapus

    </button>


</form>


</td>


</tr>


@empty

<tr>

<td colspan="3">
    Belum ada data jabatan.
</td>

</tr>


@endforelse


</tbody>


</table>


</body>
</html>