<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index()
    {
         return response()->json([
                        'responsecode' => '1',
                        'responsemsg' => 'Selamat datang',
                        'responsedata' => User::all()
                    ], 200);
    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'responsecode' => '1',
            'responsemsg' => 'Data found',
            'user' => $user
        ], 200);
    }
    public function login(Request $request)     
    {
        $hasher = app()->make('hash');
        $email = $request->email;
        $password = $request->password;

        $login = User::where(['email'=> $email, 'level'=>'3'])->first();

        $userNull = [
            'id' => 0,
            'level' => '',
            'photo' => '',
            'name' => '',
            'email' => '',
        ];

        if(!$login){

            return response()->json([
                'responsecode' => '0',
                'responsemsg' => 'Maaf email anda tidak terdaftar',
                'user' => $userNull
            ], 200);
        }else{
            if($hasher->check($password, $login->password)){

                $data = User::where('id', $login->id)->first();

                    return response()->json([
                        'responsecode' => '1',
                        'responsemsg' => 'Selamat datang',
                        'user' => $data
                    ], 200);
                
            }else{
                return response()->json([
                    'responsecode' => '0',
                    'responsemsg' => 'Maaf password anda salah',
                    'user' => $userNull
                ], 200);
            }
        }

    }
    public function update(Request $request)
    {
        $name = $request->name;
        $pass = $request->password;
        $id = $request->id;

        $data['name'] = $request->name;

        if($pass != "null"){
            // return "has";
            $data['password'] = Hash::make($pass);
        }else{
            // return "not has";

        }

        $update = User::find($id)->update($data);

        $userNull = [
            'id' => 0,
            'level' => '',
            'photo' => '',
            'name' => '',
            'email' => '',
        ];

        $user = User::find($id);
        if ($update) {
            return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Success',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'responsecode' => '0',
                'responsemsg' => 'Failed',
                'user' => $userNull
            ], 200);
        }
        

    }
}
