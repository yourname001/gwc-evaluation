<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:departments.index', ['only' => ['index']]);
		$this->middleware('permission:departments.create', ['only' => ['create','store']]);
		$this->middleware('permission:departments.show', ['only' => ['show']]);
		$this->middleware('permission:departments.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:departments.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::select('*');
        $departments = $departments->get();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('departments.create')->render()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:departments,name'],
        ]);

        Department::create([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('departments.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('departments.show', compact('department'))->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('departments.edit', compact('department'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => ['required', 'unique:departments,name,'.$department->name],
        ]);

        $department->update([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('departments.index')->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
	{
		if (request()->get('permanent')) {
			$department->forceDelete();
		}else{
			$department->delete();
		}
		return redirect()->route('departments.index')->with('alert-danger','Deleted');
	}

	public function restore($department)
	{
		$department = Department::withTrashed()->find($department);
		$department->restore();
		return redirect()->route('departments.index')->with('alert-success','Restored');
    }
}
