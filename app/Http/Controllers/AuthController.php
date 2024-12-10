<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
   
        $validator=Validator::make($request->all(),[
            'email'=>['required','email','unique:users'],
                'password'=>['required','min:6'],
                'name'=>['required','string'],
                'image'=>['required','image','mimes:jpeg,png,jpg,svg'],
                'phone'=>['required','min:6'],
             
  ]);
  if($validator->fails()){
      return response()->json([
        'status'=>'fail',
          'errors'=>$validator->errors()
      ],422);
  }
  $data=$request->only('email','password','name','image','phone','city','state');
  $imgName=Str::random(32).".".$request->image->getClientOriginalExtension();
  $request->image->move('user/userImage',$imgName);
//
// $image=$request->image;
// $imagename=time().'.'.$image->getClientOriginalExtension();
// $request->image->move('admin/typeImage',$imagename);
// $type->image=$imagename;
//
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'image'=>$imgName,
            'phone'=>$request->phone,
          
        ]);
        $token=$user->createToken('auth_token')->plainTextToken;
        return [
            'status'=>'success',
        'user'=>$user,
        'token'=>$token
        ];
            }

            public function r(){
                return 'lol';
            }
}
