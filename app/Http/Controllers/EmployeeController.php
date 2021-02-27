<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    /**
     * Display a listing of the employees.
     *
     * @return Response json
     */
    public function index()
    {
        $employees = Employee::join('departments', 'departments.id', '=', 'employees.department_id')
            ->select('employees.*', 'departments.name AS department_name')
            ->orderBy('id', 'desc')->paginate(15);
        return response()->json(['employees' => $employees], 200);
    }

    /**
     * Display a listing of the departments filter.
     *
     * @return Response
     */

    public function search(){


        if (request('department')){
            $employees = Employee::when(request('department'), function($query) {
                $query->where('department_id','' . request('department') . '');
            })->orderBy('id', 'desc')->paginate(15);
            return response()->json([ 'employees' => $employees ],200);
        }

        $employees = Employee::when(request('search') || request('department'), function($query) {
            $query->where('first_name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('last_name','LIKE','%' . request('search') . '%')
                ->orWhere('middle_name','LIKE','%' . request('search') . '%');
            if (!empty(request('department'))){
                $query->where('department_id','' . request('department') . '');
            }
        })->orderBy('id', 'desc')->paginate(15);
        return response()->json([ 'employees' => $employees ],200);
    }


    /**
     * Store a newly created employee in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {


        $request->validate([
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'middle_name' => 'max:60',
            'address' => 'required|max:120',
            'department_id' => 'required|max:20',
            'city_id' => 'required|max:20',
            'state_id' => 'required|max:20',
            'country_id' => 'required|max:20',
            'zip' => 'required|max:60',
            'birthday' => 'date',
            'date_hired' => 'date',
        ]);


        $employee = new Employee([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'zip' => $request->zip,
            'birthday' => $request->birthday,
            'date_hired' => $request->date_hired,

        ]);

        ;

        if (!$employee->save()){
            return response()->json(['message' => 'Employee not create. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Employee has been created'], 201);
    }

    /**
     * Display the specified employee.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json(['employee_profile' => $employee], 200);
    }

    /**
     * Edit the specified employee.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['employee' => $employee], 200);
    }


    /**
     * Update the specified employee in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'middle_name' => 'max:60',
            'address' => 'required|max:120',
            'department_id' => 'required|max:20',
            'city_id' => 'required|max:20',
            'state_id' => 'required|max:20',
            'country_id' => 'required|max:20',
            'zip' => 'required|max:60',
            'birthday' => 'date',

        ]);

        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->middle_name = $request->middle_name;
            $employee->address = $request->address;
            $employee->department_id = $request->department_id;
            $employee->city_id = $request->city_id;
            $employee->state_id = $request->state_id;
            $employee->country_id = $request->country_id;
            $employee->zip = $request->zip;
            $employee->birthday = $request->birthday;
            $employee->date_hired = $request->date_hired;

        if (!$employee->save()){
            return response()->json(['message' => 'Employee not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Employee has been updated'], 200);

    }

    /**
     * Remove the specified employee from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        if (!$employee->delete()){
            return response()->json(['message' => 'Employee not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Employee has been deleted'], 200);

    }

}
