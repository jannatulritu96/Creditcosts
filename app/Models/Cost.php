<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $table = 'costs';
    protected $fillable = ['user_id','title','description','amount','cost_date','category_id'];

    public function relUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function relCategory()
    {
        return $this->belongsTo(Category::Class,'category_id','id');
    }

}
