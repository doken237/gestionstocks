<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'reference'=>'required|string',
                'titre'=>'required',
                'stock'=>'integer',
                'prix'=>'required',
                'description'=>'required'
            ]);
            $data=$request->all();
            if(empty($request['stock']))
            {
                $data['stock']=0;
            }


           if (!is_numeric($request['prix']))
           {
            return response()->json(
                ['message'=>'votre prix n\'est pas valide',
                'status'=>false
                ]);
           }
          
            $data['user_id']=Auth::user()->id;
            $article=Article::create($data);
            return response()->json([
                'message'=>'Article create',
                'article_id'=>$article->id,
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
            $article = Article::all(['reference','titre','description','prix','stock']); //Récupération de toutes la catégories.
           
                return response()->json([
                    'message'=>'Affichages des articles',
                    'user_id'=>$article,
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
           $article=Article::where('id',$request['id'])->first(['user_id','reference','titre','description','prix','stock']);
            if (!$article){
                return response()->json([
                    'message'=>'Cet article n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();
            }
           return response()->json([
            'message'=>'Affichages des details',
            'id'=>$article,
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
            $id=$request['article_id'];
            $article= Article::find($id);
            if (!$article){
                return response()->json([
                    'message'=>'Cette article n\'existe pas!',
                    'status'=>false
                ]);
                die();
            }
            $article->update($data);
            return response()->json([
                'message'=>'article Update',
                'status'=>true
            ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ]);       
        }
    }
}
