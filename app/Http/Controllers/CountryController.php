<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the countries with pagination.
     *
     * @return Response
     */
    public function index()
    {
        $countries = Country::orderBy('name', 'ASC')->paginate(15);
        return response()->json(['countries' => $countries], 200);
    }

    /**
     * Display a listing of the countries filter.
     *
     * @return Response
     */

    public function search(){
        $countries = Country::when(request('search'), function($query) {
            $query->where('name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('country_code','LIKE','%' . request('search') . '%');
        })->orderBy('id', 'desc')->paginate(15);

        return response()->json([ 'countries' => $countries ],200);
    }

    /**
     * Display a listing of the countries.
     *
     * @return Response
     */
    public function all()
    {
        $countries = Country::all();
        return response()->json(['countries' => $countries], 200);
    }


    /**
     * Store a newly created country in storage.
     *
     * @param Request $request
     * @return Response json
     */
    public function create(Request $request)
    {

        $request->validate([
            'code' => 'required|max:3',
            'name' => 'required|unique:countries|max:60',
        ]);

        $country = new Country([
            'country_code' => $request->code,
            'name' => $request->name,
        ]);

        if (!$country->save()){
            return response()->json(['message' => 'Country not register. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Country has been Created'], 201);
    }

    /**
     * Display the specified country.
     *
     * @param int $id
     * @return Response json
     */
    public function show($id)
    {
        $county = Country::find($id);
        if (!$county) {
            return response()->json(['message' => 'Country not found'], 404);
        }
        return response()->json(['country' => $county], 200);
    }

    /**
     * Edit the specified country.
     *
     * @param int $id
     * @return Response json
     */
    public function edit($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        return response()->json(['country' => $country], 200);
    }


    /**
     * Update the specified country in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'country_code' => 'required|max:3',
            'name' => 'required|unique:countries|max:60',
        ]);

        $country = Country::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->country_code = $request->country_code;
        $country->name = $request->name;


        if (!$country->save()){
            return response()->json(['message' => 'Country not update. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Country has been updated'], 200);

    }

    /**
     * Remove the specified country from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        if (!$country->delete()){
            return response()->json(['message' => 'Country not delete. Internal Server Error'], 500);
        }

        return response()->json(['message' => 'Country has been deleted'], 200);

    }
}
