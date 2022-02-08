<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $users =User::all();
        return view('admin.employee',compact('users'));
    }

    public function create()
    {
        
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:users|max:33|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]); 
        
        $name=$request->name;
        $email=$request->email;
        $function=$request->function;
        $password=Hash::make($request->password);

        $user=User::create([
            'name' => $name,
            'email' => $email,
            'function' => $function,
            'password' => $password
        ]);
        if($request->has('admin'))
        {
            $user->attachRole("admin");
        }else{
            $user->attachRole("user");
        }
        

        return redirect()->back()->with(['success' => 'Ajouté avec success']);
    }

    public function deleteEmploye($id_delete)
    {
        $user =User::find($id_delete);
        $user->delete();
        return redirect()->back()->with(['success' => 'La suppression avec succès']);
        
    }

    public function edit($id_edit)
    {
        $user =User::find($id_edit);
        return view('admin.modifier')->with(['user'=>$user]);     
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required|max:33|min:3',
            'email' => 'required|email',
        ]); 
        $name=$request->name;
        $email=$request->email;
        $function=$request->function;
        $password=$user->password;

        $user->update([
            'name' => $name,
            'email' => $email,
            'function' => $function,
            'password' => $password,
        ]);

        if($request->has('admin'))
        {
            $user->detachRole($request->admin);
            $user->attachRole("admin");
        }else{
            $user->detachRole($request->admin);
            $user->attachRole("user");
        }

        return redirect()->back()->with(['success' => 'La modification avec success']);
    }
}
