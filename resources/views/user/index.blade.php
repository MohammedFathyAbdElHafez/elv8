@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All users') }}</div>

                <ul style="list-style-type:none;">
                    <li>
                        @role('admin')
                        <button type="button" class="btn btn-primary" onclick="{{ url('create/employee') }}">{{ __('Create Employee') }} </button>
                        @endrole
                    </li>

                    <li>
                        @hasanyrole('admin|employee')
                        <button type="button" class="btn btn-primary" onclick="{{ url('create/customer') }}">{{ __('Create Customer') }}</button>
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
                                <th scope="col">Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="{{ $user->role }}">{{ $user->role }}</td>
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