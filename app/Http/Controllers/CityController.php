<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the cities.
     *
     * @return Response
     */
    public function index()
    {

        $cities = City::join('states', 'states.id', '=', 'cities.state_id')->join('countries', 'countries.id', '=', 'states.country_id')
            ->select('cities.*', 'countries.name AS country_name','states.name AS state_name')
            ->orderBy('id', 'desc')->paginate(15);
        return response()->json(['cities' => $cities], 200);
    }

    /**
     * Display a listing of the cities filter.
     *
     * @return Response
     */

    public function search(){
        $cities = City::when(request('search'), function($query) {
            $query->join('states', 'states.id', '=', 'cities.state_id')->join('countries', 'countries.id', '=', 'states.country_id')
                ->where('states.name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('countries.name','LIKE','%' . request('search') . '%')->select('cities.*', 'countries.name AS country_name','states.name AS state_name');

        })->orderBy('states.id', 'desc')->paginate(15);

        return response()->json([ 'cities' => $cities ],200);
    }

    /**
     * Display a listing of the cities.
     *
     * @param $id /state id
     * @return Response
     */
    public function all($id)
    {
        $cities = City::where('state_id',''.$id.'')->get();
        return response()->json(['cities' => $cities], 200);
    }

    /**
     * Store a newly created city in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {

        $request->validate([
            'state_id' => 'required|max:20',
            'name' => 'required|unique:cities|max:60',
        ]);

        $city = new City([
            'state_id' => $request->state_id,
            'name' => $request->name,
        ]);

        if (!$city->save()){
            return response()->json(['message' => 'City not register. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'City has been created'], 201);
    }

    /**
     * Display the specified city.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $city = City::join('states', 'states.id', '=', 'cities.state_id')->where('cities.id',''.$id.'')
            ->select('cities.*', 'states.country_id AS country_id')->first();
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }
        return response()->json(['city' => $city], 200);
    }

    /**
     * Edit the specified city.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $city = City::join('states', 'states.id', '=', 'cities.state_id')->where('cities.id',''.$id.'')
            ->select('cities.*', 'states.country_id AS country_id')->first();
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        return response()->json(['city' => $city], 200);
    }


    /**
     * Update the specified city in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|max:20',
            'name' => 'required|unique:cities|max:60',
        ]);

        $city = City::find($id);
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        $city->state_id = $request->state_id;
        $city->name = $request->name;


        if (!$city->save()){
            return response()->json(['message' => 'City not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'City has been updated'], 200);

    }

    /**
     * Remove the specified city from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        if (!$city->delete()){
            return response()->json(['message' => 'City not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => $city.name.' City has been deleted'], 200);

    }
}
