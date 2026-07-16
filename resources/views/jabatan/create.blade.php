<!DOCTYPE html>
<html>
<head>
    <title>Tambah Jabatan</title>
</head>

<body>

<h1>Tambah Jabatan</h1>


@if($errors->any())

<div style="color:red">

<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif



<form action="{{ route('jabatan.store') }}" method="POST">

@csrf


<p>

<label>
Nama Jabatan
</label>

<br>

<input 
    type="text"
    name="nama_jabatan"
    value="{{ old('nama_jabatan') }}"
    required
>

</p>


<p>

<label>
Level Jabatan
</label>

<br>

<input 
    type="text"
    name="level_jabatan"
    value="{{ old('level_jabatan') }}"
    required
>

</p>



<button type="submit">
Simpan
</button>


<a href="{{ route('jabatan.index') }}">
Kembali
</a>


</form>


</body>
</html>