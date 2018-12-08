<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $id = auth()->id();
        $users = User::where('id', '!=', $id)->get();
        return response()->json($users);
    }

    public function profile() {
        return view ('user.profile');
    }

    public function fileUpload(Request $request)
    {

        $this->validate($request, [
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|min:3|max:50'
        ]);

        $user = User::findOrfail(auth()->id());
        $user->name = $request->name;
        
        if($request->hasFile('image')) {

            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imagename']);
            $user->profile = $input['imagename'];
        }

        $user->save();

        return back()->with('success','Image Upload successful');

    }

}
