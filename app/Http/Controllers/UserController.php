<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagename = 'User List';
        $pagination = 10;

        $users = User::where('role','<>','admin');

        if(isset($_GET['orderBy']) || isset($_GET['search']) || isset($_GET['location'])){
            if(isset($_GET['orderBy'])){
                $users->orderBy($_GET['orderBy'],$_GET['sortBy']);
            }

            if(isset($_GET['search'])){
                $users->where('name','like','%'.$_GET['search'].'%');
            }

            if(isset($_GET['location'])){
                $users->where('location',$_GET['location']);
            }

            if(isset($_GET['location'])){
                $users->where('location',$_GET['location']);
            }


        } else {
            $users->orderBy('updated_at','desc');
        }

        $users = $users->paginate($pagination);

        return view('maintenance.user.index',compact('pagename','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagename = 'Create User';

        return view('maintenance.user.create',compact('pagename'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        Validator::make($request->all(), [
            'username' => 'required|unique:users,name',
            'employee' => 'required',
            'password' => [
                'required',
                'max:150',
                'min:8',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'password_confirmation' => 'required|same:password',
        ])->validate();

        User::create([
            'name' => $request->employee,
            'username' => $request->username,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
            'location' => $request->location,
            'status' => 'ACTIVE',
            'remember_token' => Str::random(60)
        ]);

        return redirect(route('users.index'))->with('success','User has been added.');
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
        $pagename = 'Edit User';

        $user = User::find($id);

        return view('maintenance.user.edit',compact('pagename','user'));
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
        User::find($id)->update([
            'username' => $request->username,
            'location' => $request->location,
            'role' => $request->role
        ]);

        return redirect(route('users.index'))->with('success','User details has been updated.');
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
    }

    public function change_status(Request $request)
    {
        User::find($request->userid)->update(['status' => $request->userstatus]);

        return back()->with('success','User status has been changed into '.$request->userstatus);
    }

    public function reset_password(Request $request)
    {
        User::find($request->userid)->update([
            'password' => \Hash::make('P@ssw0rd')
        ]);

        return back()->with('success','User password has been resetted.');
    }

    public function change_password()
    {
        $pagename = 'Change Password';

        return view('maintenance.user.change-password',compact('pagename'));
    }

    public function update_password(Request $request)
    {
        Validator::make($request->all(), [
            'new_password' => [
                'required',
                'max:150',
                'min:8',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'confirm_password' => 'required|same:new_password',
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }]
        ])->validate();


        $is_updated = User::find(auth()->user()->id)->update(['password' => \Hash::make($request->confirm_password)]);

        if($is_updated) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Password successfully change. To login again, please use your new password!');
        } else {
            return back()->with('duplicate', 'Error changing password. Try again later.');
        }

    }
}
