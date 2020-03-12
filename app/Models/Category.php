<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name'];

    public function relCost()
    {
        return $this->hasMany(Cost::Class,'category_id', 'id');
    }
    public function balance(){

        return $this->hasMany(BalanceHistory::class,'category_id','id');
    }
}
