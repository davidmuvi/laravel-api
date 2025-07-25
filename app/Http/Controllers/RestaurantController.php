<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Show all restaurants.
     */

    public function index()
    {
        $restaurants = Restaurant::all();

        if (!$restaurants) {
            return response()->json(['message' => 'No restaurants found'], 404);
        }

        // Return the list of restaurants in JSON format with HTTP 200 OK
        return response()->json(data: $restaurants, status: 200);
    }

    /**
     * Find a restaurant by its ID
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        // Return the restaurant data in JSON format with HTTP 200 OK
        return response()->json(data: $restaurant, status: 200);
    }

    /**
     * Find a restaurant by its name
     */
    public function showByName(string $name)
    {
        $restaurant = Restaurant::where('name', $name)->first();

        if (!$restaurant) {
            return response()->json(['message' => "Restaurant with name $name not found"], 404);
        }

        // Return the restaurant data in JSON format with HTTP 200 OK
        return response()->json(data: $restaurant, status: 200);
    }

    /**
     * Create a new restaurant
     */

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:128',
            'address' => 'required|string|max:256',
            'phone' => 'required|string|max:32|regex:/^\d+$/'
        ]);

        $restaurant = Restaurant::create($request->all());
        // Check if the restaurant was created successfully
        if (!$restaurant) {
            return response()->json(['message' => 'Failed to create restaurant'], 500);
        }

        $data = [
            'message' => 'Restaurant created',
            'restaurant' => $restaurant
        ];

        // Return the created restaurant data in JSON format with HTTP 201 Created
        return response()->json(data: $restaurant, status: 201);
    }

    /**
     * Update a restaurant by its ID
     */
    public function update($id, Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|string|max:128',
            'address' => 'sometimes|string|max:256',
            'phone' => 'sometimes|string|max:32|regex:/^\d+$/'
        ]);

        $restaurant = Restaurant::find($id);

        // If no restaurant is found, return a 404 error response
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        // Update restaurant fields, excluding 'created_at' to avoid accidentally overwriting it
        $restaurant->update($request->except(['created_at']));

        $data = [
            'message' => 'Restaurant updated',
            'restaurant' => $restaurant
        ];

        // Return the updated restaurant data in JSON format with HTTP 200 OK
        return response()->json(data: $restaurant, status: 200);
    }

    /**
     * Delete a restaurant by its ID
     */
    public function destroy($id) {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        $restaurant->delete();

        // Return a success message in JSON format with HTTP 200 OK
        return response()->json(['message' => 'Restaurant deleted'], 200);
    }
}
