<?php

namespace App\Http\Controllers;

use App\Models\FinalAmount;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function store(Request $request)
    {
        $employee = Employee::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'password' => $request->password,
            ]
        );
        $employee->finalAmounts()->create([
            'final_amount' => $request->final_amount,
            'next_discount' => $request->next_discount || 0,
        ]);

        return response()->json($employee);
    }

    public function checkUserExistence(Request $request)
    {
        $value = $request->value;
        $user = FinalAmount::whereHas('employee', function ($query) use ($value) {
            $query->where('username', $value)->orWhere('email', $value);
        })->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'next_discount' => $user->next_discount
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function getAllEmployees()
    {
        $employees = Employee::all();
    
        return response()->json($employees);
    }
    


}
