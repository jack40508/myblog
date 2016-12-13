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
		$essay = $this->essay->where('writer',Auth::user()->id)->join('essaygroups',function($join)
																		{
																			$join->on('essaies.group','=','essaygroups.id')
																				->select('essaygroups.id as groupid');
																		}
																		)->get();

		return($essay);
		//return view('blog/index',compact('essay'));
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
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
	}
}
