<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ajout_stock;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;


class Ajoutcontroller extends Controller
{
    
        public function create(Request $request){
            try{
                $data=$request->validate([
                    'stock_ajout'=>'required|integer',
                    'article_id'=>'required|integer'
                ]);
                $data=$request->all();
               $data['user_id']=Auth::user()->id;
               $data['article_id']=$request['article_id'];
            //    $data['stock_ajout']=$request['stock_ajout'];
               $ajout=Ajout_stock::create($data);
               $article=Article::find($request['article_id']);
               $article->stock=$article->stock+$request['stock_ajout'];
               $article->save();
               return response()->json([
                    'message'=>'Ajout effectuer',
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
