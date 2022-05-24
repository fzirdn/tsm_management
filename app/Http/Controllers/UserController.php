<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use Spatie\Permission\Models\Role;

use DB;
use Hash;
use Log;

use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::orderBy('id', 'Desc')->paginate(5);
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.userForm', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'type' => 'required'
        ]);

        $input =$request->all();

        $input['password'] = Hash::make($input['password']);

        foreach ($request->input('type', []) as $key => $type)
        {
            if( ($type) == 'admin')
            {
                $input['type'] = ($request->has('type') && $input['type'])? 1: 0;
            }
            else
            {   
                $input['type'] = ($request->has('type') && $input['type']) ? 0 : 1;
            }
        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        return view('users.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $type = User::pluck('type');

        return response()->json($data);

        /*$user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));*/


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

        Log::debug($request->type);
        
        $data = User::find($request->id);
        $data->id = $request->input('id');
        $data->name = $request->input('name');
        $data->username = $request->input('username');

        foreach ($request->input('type', []) as $key => $type)
        {
            if( ($type) == 'admin')
            {
                $data['type'] = ($request->has('type') && $data['type'])? 1: 0;
            }
            else
            {   
                $data['type'] = ($request->has('type') && $data['type']) ? 0 : 1;
            }
        }

    
        $data->update();


        return redirect()->route('users.index')
                 ->with('success', 'Task Updated successfully');


        /*$this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password']))
        {
            $input['password'] = Hash::make($input['password']);
        }
        else 
        {
            $input = Arr::expect($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_has_role',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                          ->with('succes', 'User updated successfully');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                           ->with('success', 'User deleted successfully');

    }

    
}
