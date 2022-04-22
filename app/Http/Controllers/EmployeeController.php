<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::orderBy('id')->get()->all();

        $employees = array_map(function ($employee) {

            $users = DB::table('users')->where('id', $employee->user_id)->first();

            $employee->name = $users->name;
            $employee->email = $users->email;

            return $employee;
        }, $employees);

        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $customers = Customer::with('user')->orderBy('id')->get()->all();

        $customers = array_map(function ($customer) {

            $users = DB::table('users')->where('id', $customer->user_id)->first();

            $customer->name = $users->name;

            return $customer;
        }, $customers);

        return view('employee.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreRequest $request)
    {
        //
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'remember_token' => Hash::make($validated['password_confirmation'])
        ]);

        $lastId = $user->id;

        $user->assignRole('employee');

        $user->givePermissionTo('create customers');

        $createEmployee = Employee::create([
            'starting_date' =>  now(),
            'user_id' => $lastId,
        ]);

        $employeeId = $createEmployee->id;


        $employee = Employee::find($employeeId);
        $employee->customers()->sync($validated['customer_id']);


        return redirect('employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $user = User::findOrFail($employee['user_id']);

        $user['id'] = $employee['id'];
        $user['starting_date'] = $employee['starting_date'];

        return view('employee.show', ['employee' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        $user = User::findOrFail($employee['user_id']);

        $user['id'] = $employee['id'];
        $user['starting_date'] = $employee['starting_date'];
        $user['user_id'] = $employee['user_id'];


        $results = DB::select('select customer_id from customer_employee where employee_id = ?', [$user['id']]);

        $customer_id = [];
        foreach ($results as $value) {
            $customer_id[] = $value->customer_id;
        }

        $user['customer_id']  = $customer_id;

        $customers = Customer::with('user')->orderBy('id')->get()->all();

        $customers = array_map(function ($customer) {

            $users = DB::table('users')->where('id', $customer->user_id)->first();

            $customer->name = $users->name;

            return $customer;
        }, $customers);

        return view('employee.edit', ['customers' => $customers,'employee' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        //
        $validated = $request->validated();

        $user = User::find($employee['user_id']);
        $user->name       = $validated['name'];
        $user->email       = $validated['email'];
        $user->save();

        $employee = Employee::find($employee['id']);
        $employee->starting_date       = $validated['starting_date'];
        $employee->user_id       = $validated['user_id'];
        $employee->save();

        $employee->customers()->sync($validated['customer_id']);


        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->customers()->detach($employee);
        $employee->delete();
        return redirect('employees');
    }
}
