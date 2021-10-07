<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Module;
use Illuminate\Http\Request;
use App\Services\RoleRightService;

class PermissionController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Permissions Maintenance");

        $view = $rolesPermissions['view'];
        if (!$view) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];

        $pagename = 'Permissions';
        $pagination = 10;

        
        $permissions = Permission::orderBy('module_type','asc')->orderBy('description', 'asc');

        if(isset($_GET['orderBy']) || isset($_GET['search'])){
            if(isset($_GET['orderBy'])){
                $permissions->orderBy($_GET['orderBy'],$_GET['sortBy']);
            }

            if(isset($_GET['search'])){
                $permissions->where('description','like','%'.$_GET['search'].'%');
            }

        } else {
            $permissions->orderBy('updated_at','desc');
        }
        
        $modules = Module::orderBy('description','asc')->get();
        $permissions = $permissions->paginate($pagination);
        
        return view('maintenance.permission.index',compact('pagename','permissions','modules','create','edit'));
                        
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
            'module_type' => 'required',
            'description' => 'required',
        ]);
        
        if(Permission::where('module_type',$request->module_type)
        ->where('description',$request->description)
        ->exists())

        {
            return back()->with('duplicate','<strong>Permission !</strong> already exists.');
        }
        else
        {
            $status = $request->has('active');

            Permission::create([
                'module_type' => $request->module_type,
                'description' => $request->description,
                'active' => $status              
            ]);

            return back()->with('success','Permission has been added.');

        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function permission_update(Request $request)
    {
        if(Permission::where('module_type',$request->module_type)
        ->where('description',$request->description)
        ->where('id', '<>', $request->nameid)
        ->exists())

        {
            return back()->with('duplicate','<strong>Permission !</strong> already exists.');
        }
        else
        {         
            $status = $request->has('eactive');

            Permission::find($request->nameid)->update([            
                'module_type' => $request->module_type,
                'description' => $request->description,
                'active' => $status             
            ]);
    
            return back()->with('success','Permission details has been updated.');            
        }
    }

}
