<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


    /**
     * Menampilkan profil user yang sedang login
     */
    public function index()
    {

        $user = Auth::user();


        return view(
            'profile.index',
            compact('user')
        );

    }





    /**
     * Halaman edit profil
     */
    public function edit()
    {

        $user = Auth::user();


        return view(
            'profile.edit',
            compact('user')
        );

    }







   public function update(Request $request)
{

    $user = Auth::user();


    $request->validate([

        'name' => 'required',
        'email' => 'required|email',

        'current_password' => 'nullable',
        'password' => 'nullable|min:8|confirmed',

    ]);



    $pesan = "Profil berhasil diperbarui";


    // Jika user ingin mengganti password
    if($request->filled('password'))
    {


        if(!Hash::check(
            $request->current_password,
            $user->password
        ))
        {

            return back()
                ->withErrors([
                    'current_password'=>'Password lama tidak sesuai'
                ]);

        }



        $user->password = Hash::make(
            $request->password
        );


        $pesan = "Password berhasil diubah";


    }




    $user->name = $request->name;

    $user->email = $request->email;
  


    $user->save();



    return redirect()

        ->route('profile')

        ->with(
            'success',
            $pesan
        );


}


}