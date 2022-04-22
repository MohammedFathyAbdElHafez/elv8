@extends('layouts.app')

@section('content')
@role('admin')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Employees') }}</div>

                <ul style="list-style-type:none;">
                    <li>
                        @role('admin')
                        <a href="{{ route('employees.create') }}" class="btn btn-primary" role="button">{{ __('Create Employee') }}</a>
                        @endrole
                    </li>

                    <li>
                        @hasanyrole('admin|employee')
                        <a href="{{ route('customers.create') }}" class="btn btn-primary" role="button">{{ __('Create Customer') }}</a>
                        @endhasanyrole
                    </li>

                </ul>


                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">fullName</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">starting_date</th>
                                <th scope="col">Show</th>
                                <th scope="col">edit</th>
                                <th scope="col">delete</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <th scope="row">{{ $employee->id }}</th>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->starting_date }}</td>
                                <td>
                                    <a href="{{ route('employees.show',$employee->id) }}" class="btn btn-secondary" role="button">{{ __('Show Employee') }}</a>
                                </td>

                                <td>
                                    <a href="{{ route('employees.edit',$employee->id) }}" class="btn btn-primary" role="button">{{ __('Edit') }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onClick="return confirm('Are You Absolutely Sure You Want to Delete the Data?')">Delete</button>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@else

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __('This page is open only for admins!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection