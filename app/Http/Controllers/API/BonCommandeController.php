<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bon_commande;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class BonCommandeController extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'stock'=>'required|integer',
               'article_id'=>'required|integer' 
            ]);
           $data=$request->all();
           $data['user_id']=Auth::user()->id;
           $data['article_id']=$request['article_id'];
           $boncommande=Bon_commande::create($data);
           return response()->json([
                'message'=>'Bon create',
                'user_id'=>$boncommande->user_id,
                'article_id'=>$boncommande->article_id,
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

public function update(Request $request){
    try{
        $data=$request->all();
        $article_id=$request['article_id'];
        $user_id=Auth::user()->id;
        $id=$request['id'];
        $user=Bon_commande::where('id',$request['id'])->first(['id','user_id']);
        $bons=Bon_commande::find($id);
        if (!$bons){
            return response()->json([
                'message'=>'Ce bon n\'existe pas!',
                'status'=>false,
                'user'=>$bons->id
            ]);
            die();
        }
        if (($user->user_id!=$user_id)) {
            return response()->json([
                'message'=>'Ce  n\'est pas vous qui avez creer ce bon de commande!',
                'status'=>false,
                
           
                
            ]);
            die();
        }
        
        $bons->update($data);
        return response()->json([
            'message'=>'Bon mis a jour Update',
            'status'=>true,
            'user'=>$user_id
        ]);
    }
    catch(\Throwable $th)
    {
        return response()->json(
            ['message'=>$th->getMessage(),
            'status'=>false,
            'user'=>$user->user_id
            ]);       
    }
}
}