<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'email'=>'required|email|unique:users',
                'role'=>'required|integer',
                'telephone'=>'required|unique:users',
                'password'=>'required',
                'name'=>'required'
            ]);
            
            $data=$request->all();
            $data['name']= uniqid();
            $data['password']=Hash::make($request->password);
            $user=User::create($data);
            return response()->json([
                'message'=>'User create',
                'user_id'=>$user->id,
                'status'=>true
            ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );  
        }
    }

    public function listes(Request $request){ 
        try{
            $users = User::all(['email','name','telephone','role']); //Récupération de toutes la catégories.
           
                return response()->json([
                    'message'=>'Affichages des utilisateurs',
                    'users'=>$users,
                    'status'=>true
                ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
                
            
        }
    }

    public function search(Request $request){ 
        try{
           $user=User::where('id',$request['id'])->first(['id','name','email','telephone','role']);
            if (!$user){
                return response()->json([
                    'message'=>'Cette utilisateur n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();
            }
           return response()->json([
            'message'=>'Affichages des details',
            'user_id'=>$user,
            'statut'=>true
        ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
                
            
        }
    }

    public function update(Request $request){
        try{
            $data=$request->all();
            $id=$request['user_id'];
            $user= User::find($id);
            if (!$user){
                return response()->json([
                    'message'=>'Cette utilisateur n\'existe pas!',
                    'status'=>false
                ]);
                die();
            }
            // verification de l'adresse Email
            if (isset($request['email']))
            {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'message'=> "L'adresse email ".$request['email']. "est valide.",
                        'status'=>false
                    ]);
                }  
            }

            $user->update($data);
            return response()->json([
                'message'=>'User Update',
                'status'=>true
            ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
                
            
        }
    }

    public function login(Request $request)
    {
        try {
            $data=$request->validate([
                'email'=>'required|email',
                'password'=>'required'  
            ]);

            $credentials=$request->only('email','password');

            if(Auth::attempt($credentials))
            {
                $user=User::where('email',$request['email'])->first(['id','name','email','telephone','role']);
                $token=$user->createToken('Auth_token')->plainTextToken;
                return response()->json(

                    [   'user'=>$user,
                        'token'=>$token,
                        'message'=>'Authentifacation reussi',
                        'status'=>true
                    ] );

            }
            else
            {
                return response()->json(
                    ['message'=>'vos identifiants ne correspondent pas!',
                    'status'=>false
                    ] );

            }
           
        } catch (\Throwable $th) {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
        }
    }
}
