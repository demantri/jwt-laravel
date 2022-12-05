<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // set validator before login
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        /**
        * Create User 
        */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // return response json user is created
        if ($user) {
            return response()->json(['success' => true, 'data' => $user], 200);
        }

        // return json process insert failed 
        return response()->json([
            'success' => false,
        ], 402);
    }
}
