<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function all(){
        $dataAllUsers = User::query()->paginate(5);

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $dataAllUsers
        ]);
    }

    public function add(Request $request){



        $formBodyRequest = Validator::make($request->all(),[
            'password' => 'required|min:8',
            'name' => 'required',
            'email' => 'required|email',

        ], [
            'password.min' => 'Password min 8',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already',
            'email.email' => 'Email is not valid',
            'name.required' => 'Name is required',
            'password.required' => 'Password is required',

        ]);

        if($formBodyRequest->fails()){
            return response()->json([
                'status' => false,
                'code' => 402,
                'message' => $formBodyRequest->errors()->first()
            ],402);
        }



      try{
          $data = $request->all();
          $user = new User();
          $user->name = $data['name'];
          $user->email = $data['email'];
          $user->password = $data['password'] == '' ? '' : bcrypt('password');
          $user->save();
      }
      catch (\Exception $e){

          return response()->json([
              'errors' => "Internal Server Error"
          ],500);

      }

        return response()->json([
            'status' => true,
            'code' => 201,
            'data' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]
        ],201);

    }



}
