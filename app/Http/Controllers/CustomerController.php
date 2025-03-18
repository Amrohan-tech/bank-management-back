<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request for debugging
        Log::info('Incoming Request:', $request->all());
    
        // Validate request data
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'mobile' => 'required|string|max:15' // Ensure this field is required
        ]);
    
        // Create customer
        $customer = Customer::create($validated);
    
        return response()->json([
            'message' => 'Customer added successfully!',
            'customer' => $customer
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return $customer;
    }

    public function showOneCustomer($id){
        $showCustomer= Customer::find($id);
        if($showCustomer){
            return response()->json($showCustomer->toArray(),200); 
        }
        else{
            return response()->json(['message'=>'book not found'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'mobile' => 'required|string|max:15' // Ensure this field is required
        ]);

        $customer->update($request->all());
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}