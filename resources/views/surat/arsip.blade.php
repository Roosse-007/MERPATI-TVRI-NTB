@extends('layouts.app')

@section('title','Arsip Surat')

@section('content')


<h1 class="text-4xl font-black">
Arsip Surat 🗄️
</h1>


<p class="text-slate-500 mt-2">
Dokumen surat yang tersimpan
</p>




<div class="
mt-8
bg-white
rounded-[32px]
shadow-xl
p-8
">


<table class="w-full">


<thead>

<tr class="text-left text-slate-500">

<th class="p-4">
Nomor
</th>

<th>
Perihal
</th>

<th>
Tanggal
</th>

<th>
Aksi
</th>

</tr>

</thead>


<tbody>

@forelse($surat as $item)

<tr class="border-t hover:bg-slate-50">

    <td class="p-4 font-bold">
        {{ $item->nomor_surat }}
    </td>

    <td>
        {{ $item->perihal }}
    </td>

    <td>
        {{ $item->tanggal_surat?->format('d M Y') }}
    </td>

    <td class="text-center">

        <a href="{{ route('surat.detail', $item->id) }}"
           class="text-blue-600 hover:text-blue-800">

            <i data-lucide="eye" class="w-5 h-5"></i>

        </a>

    </td>

</tr>

@empty

<tr>

    <td colspan="4" class="text-center py-8 text-slate-500">

        Belum ada surat yang diarsipkan.

    </td>

</tr>

@endforelse

</tbody>


</table>


</div>



@endsection