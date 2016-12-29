<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Essaies\EssayRepository;
use App\Essaies\EssayGroup;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EssayRepository $essay,EssayGroup $essaygroup)
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
		$essaies = $this->essay->getAllUserEssaies();
		$essaygroups = $this->essay->getAllUserGroups();

		//dd($essaygroups);

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
		$this->essay->createEssay($request);
			

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
		$essay = $this->essay->getEssayByID($id);
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
		$essay = $this->essay->getEssayByID($id);

		$essay->name = $request->input_name;
		$essay->detail = $request->input_message;
		$this->essay->createNewGroup($request->input_group);
		$essay->group_id = $this->essaygroup->where('name',$request->input_group)->first()->id;
		
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
		$this->essay->DeleteEssayByID($id);
		return redirect('blog');
	}

	public function showgroup($id)
	{
		//
		$essaies = $this->essay->getEssaiesByColumn('group_id',$id);
		$essaygroups = $this->essay->getAllUserGroups();
		$group_id = $id;

		return view('blog/index',compact('essaies','essaygroups','group_id'));
	}
}
