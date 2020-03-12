<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    protected $fillable = ['owner_id','user_id','category_id','amount','deposit_date'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
