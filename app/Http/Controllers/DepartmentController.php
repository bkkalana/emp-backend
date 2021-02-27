<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments with pagination.
     *
     * @return Response
     */
    public function index()
    {
        $departments = Department::orderBy('name', 'ASC')->paginate(15);
        return response()->json(['departments' => $departments], 200);
    }

    /**
     * Display a listing of the departments filter.
     *
     * @return Response
     */

    public function search(){
        $departments = Department::when(request('search'), function($query) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        })->orderBy('id', 'desc')->paginate(15);

        return response()->json([ 'departments' => $departments ],200);
    }

    /**
     * Display a listing of the departments.
     *
     * @return Response
     */
    public function all()
    {
        $departments = Department::all();
        return response()->json(['departments' => $departments], 200);
    }


    /**
     * Store a newly created department in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:countries|max:60',
        ]);

        $department = new Department([
            'name' => $request->name,
        ]);

        if (!$department->save()){
            return response()->json(['message' => 'Department not register. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Department has been Created'], 201);
    }

    /**
     * Display the specified department.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }
        return response()->json(['department' => $department], 200);
    }

    /**
     * Edit the specified department.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json(['department' => $department], 200);
    }


    /**
     * Update the specified department in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:countries|max:60',
        ]);

        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->name = $request->name;


        if (!$department->save()){
            return response()->json(['message' => 'Country not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Country has been updated'], 200);

    }

    /**
     * Remove the specified department from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        if (!$department->delete()){
            return response()->json(['message' => 'Department not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Departments has been deleted'], 200);

    }
}
