<?php
	
namespace App\Essaies;

use Illuminate\Http\Request;
use Auth;
use App\Essaies\Essay;
use App\EssayGroup;


class EssayRepository
{
	public function __construct(Essay $essay,EssayGroup $essaygroup)
    {
        $this->essay = $essay;
        $this->essaygroup = $essaygroup;
    }

	public function getAll()
    {
        $essaies = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id');
																		})->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->orderBy('id','DESC')->get();
        $essaies = $this->essay->get();
        return $essaies;
    }

    public function getAllGroups()
    {
        $essaygroups = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
                                                                        {
                                                                            $join->on('essaies.group','=','essaygroups.id');
                                                                        })->select('essaies.group as id','essaygroups.name as name')->distinct()->get();
        return $essaygroups;
    }

    public function getEssayByID($value)
    {
        $essaies = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join) use($value)
                                                                    {
                                                                        $join->on('essaies.group','=','essaygroups.id')
                                                                            ->where('essaies.id',$value);
                                                                    })->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->orderBy('id','DESC')->first();
        return $essaies;
    }

    public function getEssaiesByColumn($column,$value)
    {
        $essaies = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join) use($column,$value)
                                                                    {
                                                                        $join->on('essaies.group','=','essaygroups.id')
                                                                            ->where($column,$value);
                                                                    })->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->orderBy('id','DESC')->get();
        return $essaies;
    }

    public function createEssay($request)
    {
        $this->createNewGroup($request->get('input_group'));

        $newessay = new Essay;
        $newessay->name = $request->get('input_name');
        $newessay->writer = Auth::user()->id;
        $newessay->group = $this->essaygroup->where('name',$request->get('input_group'))->first()->id;
        $newessay->detail = $request->get('input_message');
        $newessay->save();  
    }

    public function createNewGroup($group_name)
    {
        if(is_null($this->essaygroup->where('name',$group_name)->first()))
        {
            $newessaygroup = new EssayGroup;
            $newessaygroup->name = $group_name;
            $newessaygroup->save();
        }
    }  

    public function deleteEssayByID($id)
    {
        $essay = $this->getEssayByID($id);
        $essay->delete();
    }  
}