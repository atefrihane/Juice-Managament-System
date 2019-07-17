<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Admin;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::query()->with('user')->with('role')->get();
       // dd($admins);
        return view("Admin::index", compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();
        $lastAdminId = Admin::all()->last()->id + 1;
        return view('Admin::addAdmin', compact("roles","lastAdminId"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      $admin =  Admin::create([
            'role_id'=> $request->role
        ]);
       $user = User::create([
        'email'         =>   $request->email,
        'code'          =>    $request->code,
        'nom'           =>    $request->nom,
        'prenom'            =>  $request->prenom,
        'civilite'          =>    $request->sexe,
        'telephone'         =>   $request->telephone,
        'accessCode'            =>  $request->accessCode,
        'password'          =>bcrypt( $request->password),
        'child_type'             => Admin::class,
        'child_id'           => $admin->id
    ]);
        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $admin = Admin::query()->where('id' ,'=', $id)->with('user')->get()->first();
        $roles = Role::all();
        return view("Admin::updateAdmin", compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $admin = Admin::find($id);
        $admin->role_id = $request->role;
        $admin->save();

        User::where('id', '=', $admin->user->id)->update([
            'email'         =>   $request->email,
            'code'          =>    $request->code,
            'nom'           =>    $request->nom,
            'prenom'            =>  $request->prenom,
            'civilite'          =>    $request->sexe,
            'telephone'         =>   $request->telephone,
            'accessCode'            =>  $request->accessCode,
            'password'          =>bcrypt( $request->password),
            'child_type'             => Admin::class,
            'child_id'           => $id
        ]);
        $user = Admin::find($id)->user;
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      $admin =   Admin::find($id);
      $user = $admin->user;

      $admin->delete();
      $user->delete();
      return redirect('/admin');
    }
}
