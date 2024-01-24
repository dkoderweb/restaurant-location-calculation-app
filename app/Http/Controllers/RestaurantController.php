<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{

    public function index(){
        $restaurants =  Restaurant::all();
        return view('index',compact('restaurants'));
    }
    public function create(){
        return view('welcome');
    }
    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'range' => 'required|integer',
        ]);

        $restaurant = Restaurant::create($data);

        return response()->json(['restaurant' => $restaurant,'success'=> 'Restaurant added successfully'], 200);
    }
}
