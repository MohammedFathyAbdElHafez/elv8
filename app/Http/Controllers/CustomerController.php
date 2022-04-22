<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\customerActions;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::with('action')->orderBy('id')->get()->all();

        $customers = array_map(function ($customer) {
            $action = $customer->action;

            $customer->action_name = $action['action_name'];
            $users = DB::table('users')->where('id', $customer->user_id)->first();

            $customer->name = $users->name;
            $customer->email = $users->email;

            return $customer;
        }, $customers);

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $employees = Employee::with('user')->orderBy('id')->get()->all();

        $employees = array_map(function ($employee) {

            $users = DB::table('users')->where('id', $employee->user_id)->first();

            $employee->name = $users->name;

            return $employee;
        }, $employees);

        $actions = customerActions::orderBy('id')->get()->all();

        return view('customer.create', ['employees' => $employees, 'actions' => $actions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
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

        $user->assignRole('customer');

        $createCustomer = Customer::create([
            'user_id' => $lastId,
            'mobile' =>  $validated['mobile'],
            'country' =>  $validated['country'],
            'city' =>  $validated['city'],
            'postal_code' =>  $validated['postal_code'],
            'address' =>  $validated['address'],
            'action_id' =>  $validated['action_id'],
        ]);

        $customerId = $createCustomer->id;


        $customer = Customer::find($customerId);
        $customer->employees()->sync($validated['employee_id']);


        return redirect('customers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
        $user = User::findOrFail($customer['user_id']);

        $user['id'] = $customer['id'];
        $user['user_id'] = $customer['user_id'];
        $user['mobile'] = $customer['mobile'];
        $user['country'] = $customer['country'];
        $user['city'] = $customer['city'];
        $user['postal_code'] = $customer['postal_code'];
        $user['address'] = $customer['address'];
        $user['action_id'] = $customer['action_id'];

        $results = DB::select('select employee_id from customer_employee where customer_id = ?', [$user['id']]);

        $employee_id = [];
        foreach ($results as $value) {
            $employee_id[] = $value->employee_id;
        }

        $user['employee_id']  = $employee_id;

        $employees = Employee::with('user')->orderBy('id')->get()->all();

        $employees = array_map(function ($employee) {

            $users = DB::table('users')->where('id', $employee->user_id)->first();

            $employee->name = $users->name;

            return $employee;
        }, $employees);

        $actions = customerActions::orderBy('id')->get()->all();

        return view('customer.edit', ['employees' => $employees, 'customer' => $user, 'actions' => $actions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        //
        $validated = $request->validated();

        $user = User::find($customer['user_id']);
        $user->name       = $validated['name'];
        $user->email       = $validated['email'];
        $user->save();

        $customer = Customer::find($customer['id']);
        $customer->user_id       = $validated['user_id'];
        $customer->mobile       = $validated['mobile'];
        $customer->country       = $validated['country'];
        $customer->city       = $validated['city'];
        $customer->postal_code       = $validated['postal_code'];
        $customer->address       = $validated['address'];
        $customer->action_id       = $validated['action_id'];
        $customer->save();


        $customer->employees()->sync($validated['employee_id']);


        return redirect('customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
        $customer->employees()->detach($customer);
        $customer->delete();
        return redirect('customers');
    }



    /**
     * getCustomerDetails.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function getCustomerDetails()
    {
        $user = Auth::user();
        $customer = Customer::with('employees', 'action')->where('user_id', $user['id'])->get()->all();

        $customer = array_map(function ($item) use ($user) {
            $action = $item->action;

            $item->action_name = $action['action_name'];

            $item->name = $user['name'];
            $item->email = $user['email'];

            return $item;
        }, $customer);

        return view('customer.show', ['customer' => $customer]);
    }
}
