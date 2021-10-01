<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagename = 'Roles';
        $pagination = 10;

        $roles = Role::whereNotNull('id');

        if(isset($_GET['orderBy']) || isset($_GET['search'])){
            if(isset($_GET['orderBy'])){
                $roles->orderBy($_GET['orderBy'],$_GET['sortBy']);
            }

            if(isset($_GET['search'])){
                $roles->where('name','like','%'.$_GET['search'].'%');
            }

        } else {
            $roles->orderBy('updated_at','desc');
        }

        $roles = $roles->paginate($pagination);
        
        return view('maintenance.role.index',compact('pagename','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'description' => 'required',
        ]);
        
        if(Role::where('name',$request->name)->exists())
        {
            return back()->with('duplicate','<strong>Role Name!</strong> already exists.');
        }
        else
        {
            $status = $request->has('active');

            Role::create([
                'name' => $request->role,
                'description' => $request->description,
                'active' => $status              
            ]);

            return back()->with('success','Role has been added.');

        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function role_update(Request $request)
    {

        if(Role::where('name',$request->name)
        ->where('id', '<>', $request->nameid)
        ->exists())
        {
            return back()->with('duplicate','<strong>Role Name!</strong> already exists.');
        }
        else
        {         
            $status = $request->has('eactive');

            Role::find($request->nameid)->update([            
                'name' => $request->name,
                'description' => $request->description,
                'active' => $status             
            ]);
    
            return back()->with('success','Role details has been updated.');            
        }
    }

}
