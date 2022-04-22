@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Customer Data') }}</div>

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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->country }}</td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->postal_code }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <a href="#" class="btn btn-info" role="button">{{ $item->action_name }}</a>
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

@endsection