<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Essay;
use App\EssayGroup;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Essay $essay,EssayGroup $essaygroup)
    {
        $this->middleware('auth');
        $this->essay = $essay;
        $this->essaygroup = $essaygroup;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$essaies = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id');
																		})->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->orderBy('id','DESC')->get();
		
		$essaygroups = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id');
																		})->select('essaies.group as id','essaygroups.name as name')->distinct()->get();
		//return($essaygroups);
		return view('blog/index',compact('essaies','essaygroups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('blog/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		//$groupcheck = EssayGroup::where('name',$request->get('input_group'))->first();

		if(is_null($this->essaygroup->where('name',$request->get('input_group'))->first()))
		{
			$newessaygroup = new EssayGroup;
			$newessaygroup->name = $request->get('input_group');
			$newessaygroup->save();
		}

		$newessay = new Essay;
		$newessay->name = $request->get('input_name');
		$newessay->writer = Auth::user()->id;
		$newessay->group = $this->essaygroup->where('name',$request->get('input_group'))->first()->id;
		$newessay->detail = $request->get('input_message');
		$newessay->save();		

		return  redirect('blog');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$essay = $this->essay->join('essaygroups',function($join) use($id)
								{
									$join->on('essaies.group','=','essaygroups.id')
									->where('essaies.id',$id);
								})->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->first();
		return view('blog/edit',compact('essay'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
		//
		$essay = $this->essay->where('id',$id)->first();

		$essay->name = $request->input_name;
		$essay->detail = $request->input_message;

		if(is_null($this->essaygroup->where('name',$request->input_group)->first()))
		{
			$newessaygroup = new EssayGroup;
			$newessaygroup->name = $request->get('input_group');
			$newessaygroup->save();
		}
		
		$essay->group = $this->essaygroup->where('name',$request->input_group)->first()->id;
		

		$essay->save();

		return redirect('blog');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$essay = $this->essay->where('id',$id)->first();
		$essay->delete();
		return redirect('blog');
	}

	public function showgroup($id)
	{
		//
		//
		$essaies = $this->essay->where('writer',Auth::user()->id)->where('group',$id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id');
																		})->select('essaies.id','essaies.name','essaies.writer','essaies.detail','essaygroups.name as group_name','essaygroups.id as group_id')->orderBy('id','DESC')->get();
		
		$essaygroups = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id');
																		})->select('essaies.group as id','essaygroups.name as name')->distinct()->get();
		$group_id = $id;
		return view('blog/index',compact('essaies','essaygroups','group_id'));
	}
}
