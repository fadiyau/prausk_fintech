<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        if($user){
            return redirect('home')->with('status','Berhasil Menambahkan User');
        }
        return redirect('home')->with('status','Gagal Menambahkan User');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        if($user){
            return redirect('home')->with('status','Berhasil Mengupdate User');
        }
        return redirect('home')->with('status','Gagal Mengupdate User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        if($user){
            return redirect('home')->with('status','Berhasil Menghapus User');
        }
        return redirect('home')->with('status','Gagal Menghapus User');
    }
}
