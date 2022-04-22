@extends('layouts.app')

@section('content')
@hasanyrole('admin|employee')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Customers') }}</div>

                <ul style="list-style-type:none;">
                    <li>
                        @hasanyrole('admin|employee')
                        <a href="{{ route('customers.create') }}" class="btn btn-primary" role="button">{{ __('Create Customer') }}</a>
                        @endhasanyrole
                    </li>

                </ul>


                <div class="card-body">
                    <table class="table table-dark table-striped customers-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">fullName</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">mobile</th>
                                <th scope="col">country</th>
                                <th scope="col">city</th>
                                <th scope="col">postal_code</th>
                                <th scope="col">address</th>
                                <th scope="col">action</th>
                                <th scope="col">edit</th>
                                <th scope="col">delete</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <th scope="row">{{ $customer->id }}</th>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->mobile }}</td>
                                <td>{{ $customer->country }}</td>
                                <td>{{ $customer->city }}</td>
                                <td>{{ $customer->postal_code }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>
                                    <a href="#" class="btn btn-info" role="button">{{ $customer->action_name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-primary" role="button">{{ __('Edit') }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="post">
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

@endhasanyrole

@endsection