<?php

namespace App\Essaies;

use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    //
    protected $table = 'essaies';
    protected $fillable = [
    		'name',
    		'writer',
    		'group_id',
    		'detail',
    ];

    public function group()
    {
        return $this->belongsTo(EssayGroup::class,'group_id','id');
    }
}
