<!DOCTYPE html>
<html>
<head>
    <title>Unit Kerja</title>
</head>
<body>

<h1>Data Unit Kerja</h1>

@if(session('success'))
    <p style="color:green">
        {{ session('success') }}
    </p>
@endif


<a href="{{ route('unit-kerja.create') }}">
    + Tambah Unit Kerja
</a>

<br><br>


<table border="1" cellpadding="8">

<thead>
<tr>
    <th>No</th>
    <th>Nama Unit</th>
    <th>Aksi</th>
</tr>
</thead>


<tbody>

@forelse($unitKerja as $unit)

<tr>

<td>
    {{ $loop->iteration }}
</td>


<td>
    {{ $unit->nama_unit }}
</td>


<td>

<a href="{{ route('unit-kerja.edit', $unit->id) }}">
    Edit
</a>


|

<form action="{{ route('unit-kerja.destroy', $unit->id) }}"
      method="POST"
      style="display:inline">

    @csrf
    @method('DELETE')

    <button type="submit"
        onclick="return confirm('Hapus unit kerja ini?')">

        Hapus

    </button>

</form>


</td>

</tr>


@empty

<tr>
<td colspan="3">
Belum ada data
</td>
</tr>

@endforelse


</tbody>

</table>


</body>
</html>