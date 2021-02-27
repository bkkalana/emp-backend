<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {

        $users = User::orderBy('id', 'ASC')->paginate(15);
        return response()->json(['users' => $users], 200);
    }

    /**
     * Display a listing of the departments filter.
     *
     * @return Response
     */

    public function search(){
        $users = User::when(request('search'), function($query) {
            $query->where('username', 'LIKE', '%' . request('search') . '%')
                ->orWhere('email', 'LIKE', '%' . request('search') . '%');
        })->orderBy('id', 'ASC')->paginate(15);

        return response()->json([ 'users' => $users ],200);
    }



    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {
         $request->validate([
            'username' => 'required|unique:users|max:20',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation',
             'role' => 'required|max:2'
        ]);

        $user = new User([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        ;

        if (!$user->save()){
            return response()->json(['message' => 'User not register. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'User has been registered'], 201);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user_profile' => $user], 200);
    }

    /**
     * Edit the specified user.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }


    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:20',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'email' => 'required|max:60',
            'role' => 'required|max:2',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;

        if (!$user->save()){
            return response()->json(['message' => 'User not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'User has been updated'], 200);

    }

    /**
     * Update Password the specified user  in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);

        if (!$user->save()){
            return response()->json(['message' => 'User password not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'User password has been updated'], 200);

    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$user->delete()){
            return response()->json(['message' => 'User not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'User has been deleted'], 200);

    }

}
