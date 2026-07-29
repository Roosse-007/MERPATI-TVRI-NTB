@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl p-10">

    <h1 class="text-3xl font-black text-slate-800 mb-8">
        Balas Surat
    </h1>

    <div class="bg-blue-50 rounded-xl p-5 mb-8">
        <p class="text-sm text-slate-500">
            Surat yang dibalas:
        </p>
        <p class="font-bold">
            {{ $surat->nomor_surat }}
        </p>
        <p>
            {{ $surat->perihal }}
        </p>
    </div>

    {{-- KOTAK NOTIFIKASI ERROR (PENTING AGAR TAHU JIKA ADA VALIDASI GAGAL) --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6">
            <p class="font-bold mb-1">Terjadi Kesalahan:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('surat.balas.store', $surat->id) }}" enctype="multipart/form-data">
        @csrf

        <label class="font-bold block mb-2">
            Tujuan Surat
        </label>
        <input 
            type="hidden" 
            name="tujuan_id" 
            value="{{ $surat->pengirim_id }}"
            >

        <div class="w-full bg-slate-100 border border-slate-200 rounded-xl p-3 mb-5 text-slate-700 font-semibold flex items-center justify-between">
            <span>{{ $surat->pengirim->name ?? 'Pengirim Asli' }}</span>
            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Otomatis</span>
        </div>

        <label class="font-bold block mb-2">
            Perihal
        </label>
      <input 
name="perihal"
value="Balasan {{ $surat->parent_surat_id 
    ? $surat->suratInduk->perihal 
    : $surat->perihal }}"
class="w-full border rounded-xl p-3 mb-5"
required> 

        <label class="font-bold block mb-2">
            Isi Balasan
        </label>
        <textarea name="catatan" rows="8" class="w-full rounded-xl border p-4 mb-5" placeholder="Tulis isi balasan surat..." required></textarea>

     
        

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            Kirim Balasan
        </button>

    </form>

</div>

@endsection