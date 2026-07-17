<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'jenis_surat_id'      => 'required|exists:jenis_surat,id',

            'sifat_surat_id'      => 'required|exists:sifat_surat,id',

            'prioritas_surat_id'  => 'required|exists:prioritas_surat,id',

            'template_surat_id'   => 'nullable|exists:template_surat,id',

            'nomor_surat'         => 'required|string|max:100|unique:surat,nomor_surat',

            'perihal'             => 'required|string|max:255',

            'ringkasan'           => 'nullable|string|max:255',

            'isi_surat'           => 'required|string',

            'tanggal_surat'       => 'required|date',

            'file_surat'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',

        ];
    }

    /**
     * Custom Error Messages
     */
    public function messages(): array
    {
        return [

            'jenis_surat_id.required'     => 'Jenis surat wajib dipilih.',

            'sifat_surat_id.required'     => 'Sifat surat wajib dipilih.',

            'prioritas_surat_id.required' => 'Prioritas surat wajib dipilih.',

            'nomor_surat.required'        => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'          => 'Nomor surat sudah digunakan.',

            'perihal.required'            => 'Perihal wajib diisi.',

            'isi_surat.required'          => 'Isi surat wajib diisi.',

            'tanggal_surat.required'      => 'Tanggal surat wajib diisi.',

            'file_surat.mimes'            => 'File harus PDF, DOC atau DOCX.',

            'file_surat.max'              => 'Ukuran file maksimal 5 MB.',
        ];
    }
}