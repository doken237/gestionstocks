<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajout_stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'article_id',
        'stock_ajout',  
    ];

    protected $guarded=['id','created_ad'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function article(){
      
        return $this->belongsTo(Article::class,'article_id');
    }
}
