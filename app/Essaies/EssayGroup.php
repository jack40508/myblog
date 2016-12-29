<?php

namespace App\Essaies;

use Illuminate\Database\Eloquent\Model;

class EssayGroup extends Model
{
    //
    protected $table = 'essaygroups';
    protected $fillable = [
    		'name',
    ];

    public function essaies()
    {
        return $this->hasMany(Essay::class,'group_id','id');
    }
}
