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


}