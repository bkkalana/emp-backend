<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the states.
     *
     * @return Response
     */
    public function index()
    {
        $states = State::join('countries', 'countries.id', '=', 'states.country_id')
            ->select('states.*', 'countries.name AS country_name')
            ->orderBy('id', 'desc')->paginate(15);
        return response()->json(['states' => $states], 200);
    }

    /**
     * Display a listing of the states filter.
     *
     * @return Response
     */

    public function search(){
        $states = State::when(request('search'), function($query) {
            $query->join('countries', 'countries.id', '=', 'states.country_id')->where('states.name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('countries.name','LIKE','%' . request('search') . '%')->select('states.*', 'countries.name AS country_name');
        })->orderBy('states.id', 'desc')->paginate(15);

        return response()->json([ 'states' => $states ],200);
    }

    /**
     * Display a listing of the states.
     *
     * @param $id /country id
     * @return Response
     */
    public function all($id)
    {
        $states = State::where('country_id',''.$id.'')->get();
        return response()->json(['states' => $states], 200);
    }

    /**
     * Store a newly created state in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {

        $request->validate([
            'country_id' => 'required|max:20',
            'name' => 'required|unique:states|max:60',
        ]);

        $state = new State([
            'country_id' => $request->country_id,
            'name' => $request->name,
        ]);

        if (!$state->save()){
            return response()->json(['message' => 'State not register. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'State has been registered'], 201);
    }

    /**
     * Display the specified state.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $state = State::find($id);
        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }
        return response()->json(['State' => $state], 200);
    }

    /**
     * Edit the specified state.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        return response()->json(['state' => $state], 200);
    }


    /**
     * Update the specified state in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|max:20',
            'name' => 'required|unique:states|max:60',
        ]);

        $state = State::find($id);
        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        $state->country_id = $request->country_id;
        $state->name = $request->name;


        if (!$state->save()){
            return response()->json(['message' => 'State not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'State has been updated'], 200);

    }

    /**
     * Remove the specified state from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json(['message' => 'State not found'], 404);
        }

        if (!$state->delete()){
            return response()->json(['message' => 'State not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => $state->name.' has been deleted'], 200);

    }
}
