<?php
	
namespace App\Essaies;

use Illuminate\Http\Request;
use Auth;
use App\Essaies\Essay;
use App\Essaies\EssayGroup;


class EssayRepository
{
	public function __construct(Essay $essay,EssayGroup $essaygroup)
    {
        $this->essay = $essay;
        $this->essaygroup = $essaygroup;
    }

	public function getAllUserEssaies()
    {
        $essaies = $this->essay->where('writer',Auth::user()->id)->orderBy('id','DESC')->get();

        return $essaies;
    }

    public function getAllUserGroups()
    {
        $essaygroups = $this->essaygroup->whereHas('essaies',function($query)
                                                            {
                                                                $query->where('writer',Auth::user()->id);
                                                            })->get();

        return $essaygroups;
    }

    public function getEssayByID($id)
    {
        $essay = $this->essay->find($id);
        return $essay;
    }

    public function getEssaiesByColumn($column,$value)
    {
        $essaies = $this->essay->where('writer',Auth::user()->id)->where($column,$value)->get();
        return $essaies;
    }

    public function createEssay($request)
    {
        $this->createNewGroup($request->get('input_group'));

        $newessay = new Essay;
        $newessay->name = $request->get('input_name');
        $newessay->writer = Auth::user()->id;
        $newessay->group_id = $this->essaygroup->where('name',$request->get('input_group'))->first()->id;
        $newessay->detail = $request->get('input_message');
        $newessay->save();  
    }

    public function createNewGroup($group_name)
    {
        $this->essaygroup->firstOrCreate(['name' => $group_name]);
    }  

    public function deleteEssayByID($id)
    {
        $essay = $this->getEssayByID($id);
        $essay->delete();
    }  
}