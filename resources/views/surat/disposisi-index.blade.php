@extends('layouts.app')

@section('title', 'Daftar Disposisi')

@section('content')

<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Daftar Disposisi</h1>

    @if($disposisi->isEmpty())
        <div class="bg-white rounded-lg shadow p-6">
            Belum ada data disposisi.
        </div>
    @else
        <table class="w-full bg-white rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Surat</th>
                    <th class="p-3 text-left">Dari</th>
                    <th class="p-3 text-left">Ke</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disposisi as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->surat->perihal ?? '-' }}</td>
                        <td class="p-3">{{ $item->dariUser->name ?? '-' }}</td>
                        <td class="p-3">{{ $item->keUser->name ?? '-' }}</td>
                        <td class="p-3">{{ $item->status }}</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('surat.disposisi', $item->surat_id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                                👁 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection