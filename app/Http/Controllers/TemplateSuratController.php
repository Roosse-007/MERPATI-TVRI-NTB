<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TemplateSuratController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $templates = TemplateSurat::latest()->get();


        $totalTemplate = TemplateSurat::count();


        $templateAktif = TemplateSurat::where(
            'is_active',
            true
        )->count();


        $templateNonaktif = TemplateSurat::where(
            'is_active',
            false
        )->count();



        return view(
            'admin.template-surat',
            compact(
                'templates',
                'totalTemplate',
                'templateAktif',
                'templateNonaktif'
            )
        );

    }









    /*
    |--------------------------------------------------------------------------
    | TAMBAH TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        $request->validate([


            'nama_template'
            =>
            'required|string|max:255',



            'file_docx'
            =>
            'nullable|file|mimes:docx|max:10240',



            'file_pdf'
            =>
            'nullable|file|mimes:pdf|max:10240',



            // untuk kompatibilitas data lama

            'file_template'
            =>
            'nullable|file|mimes:pdf,doc,docx|max:10240',



            'keterangan'
            =>
            'nullable|string'


        ]);







        $data = [


            'nama_template'
            =>
            $request->nama_template,


            'keterangan'
            =>
            $request->keterangan,


            'is_active'
            =>
            true,


        ];








        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOCX
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_docx'))
        {

            $data['file_docx'] =

            $request
            ->file('file_docx')
            ->store(
                'template',
                'public'
            );

        }









        /*
        |--------------------------------------------------------------------------
        | UPLOAD PDF
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_pdf'))
        {

            $data['file_pdf'] =

            $request
            ->file('file_pdf')
            ->store(
                'template',
                'public'
            );

        }









        /*
        |--------------------------------------------------------------------------
        | FILE LAMA
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_template'))
        {

            $data['file_template'] =

            $request
            ->file('file_template')
            ->store(
                'template',
                'public'
            );

        }








        TemplateSurat::create($data);







        return redirect()

            ->route('admin.template')

            ->with(
                'success',
                'Template berhasil ditambahkan'
            );

    }









    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $template = TemplateSurat::findOrFail($id);


        return view(
            'admin.template-edit',
            compact('template')
        );

    }











    /*
    |--------------------------------------------------------------------------
    | UPDATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {


        $template = TemplateSurat::findOrFail($id);






        $request->validate([


            'nama_template'
            =>
            'required|string|max:255',



            'file_docx'
            =>
            'nullable|file|mimes:docx|max:10240',



            'file_pdf'
            =>
            'nullable|file|mimes:pdf|max:10240',



            'file_template'
            =>
            'nullable|file|mimes:pdf,doc,docx|max:10240',



            'keterangan'
            =>
            'nullable|string',



            'is_active'
            =>
            'required|boolean'


        ]);








        $data = [


            'nama_template'
            =>
            $request->nama_template,



            'keterangan'
            =>
            $request->keterangan,



            'is_active'
            =>
            $request->is_active,


        ];









        /*
        |--------------------------------------------------------------------------
        | UPDATE DOCX
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_docx'))
        {


            if($template->file_docx)
            {

                Storage::disk('public')
                ->delete(
                    $template->file_docx
                );

            }



            $data['file_docx'] =

            $request
            ->file('file_docx')
            ->store(
                'template',
                'public'
            );


        }









        /*
        |--------------------------------------------------------------------------
        | UPDATE PDF
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_pdf'))
        {


            if($template->file_pdf)
            {

                Storage::disk('public')
                ->delete(
                    $template->file_pdf
                );

            }



            $data['file_pdf'] =

            $request
            ->file('file_pdf')
            ->store(
                'template',
                'public'
            );


        }









        /*
        |--------------------------------------------------------------------------
        | UPDATE FILE LAMA
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('file_template'))
        {


            if($template->file_template)
            {

                Storage::disk('public')
                ->delete(
                    $template->file_template
                );

            }



            $data['file_template'] =

            $request
            ->file('file_template')
            ->store(
                'template',
                'public'
            );


        }








        $template->update($data);







        return redirect()

            ->route('admin.template')

            ->with(
                'success',
                'Template berhasil diperbarui'
            );

    }











    /*
    |--------------------------------------------------------------------------
    | HAPUS TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {


        $template = TemplateSurat::findOrFail($id);





        if($template->file_docx)
        {

            Storage::disk('public')
            ->delete(
                $template->file_docx
            );

        }





        if($template->file_pdf)
        {

            Storage::disk('public')
            ->delete(
                $template->file_pdf
            );

        }





        if($template->file_template)
        {

            Storage::disk('public')
            ->delete(
                $template->file_template
            );

        }





        $template->delete();







        return redirect()

            ->route('admin.template')

            ->with(
                'success',
                'Template berhasil dihapus'
            );

    }









    /*
    |--------------------------------------------------------------------------
    | AKTIF / NONAKTIF
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {


        $template = TemplateSurat::findOrFail($id);




        $template->update([

            'is_active'
            =>
            !$template->is_active

        ]);





        return back()

            ->with(
                'success',
                'Status template berhasil diubah'
            );

    }



}