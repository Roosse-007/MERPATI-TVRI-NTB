<!DOCTYPE html>
<html>
<head>
    <title>Tambah Unit Kerja</title>
</head>

<body>

<h1>Tambah Unit Kerja</h1>


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



<form action="{{ route('unit-kerja.store') }}" method="POST">

@csrf


<p>

<label>
Nama Unit Kerja
</label>

<br>

<input 
    type="text" 
    name="nama_unit"
    value="{{ old('nama_unit') }}"
    required
>

</p>



<button type="submit">
Simpan
</button>


<a href="{{ route('unit-kerja.index') }}">
Kembali
</a>


</form>


</body>
</html>