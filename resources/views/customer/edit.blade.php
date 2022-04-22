@extends('layouts.app')

@section('content')
@hasanyrole('admin|employee')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Customer') }}</div>
                <div class="card-body">

                    <form method="POST" action="{{ route('customers.update',$customer['id']) }}">
                        @csrf
                        {{ method_field('PUT') }}

                        <input type="text" name="user_id" value="{{ $customer['user_id'] }}" hidden>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer['name'] }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer['email'] }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Assign Employees') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="employee_id[]" multiple aria-label="Default select example">
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" @foreach($customer['employee_id'] as $id) @if($employee->id == $id)selected="selected"@endif @endforeach >{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobile-number" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="mobile-number" type="number" class="form-control" value="{{ $customer['mobile'] }}" name="mobile" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" value="{{ $customer['country'] }}" name="country" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" value="{{ $customer['city'] }}" name="city" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="postalcode" class="col-md-4 col-form-label text-md-end">{{ __('Post code') }}</label>

                            <div class="col-md-6">
                                <input id="postalcode" type="text" class="form-control" value="{{ $customer['postal_code'] }}" name="postal_code" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" value="{{ $customer['address'] }}" name="address" required>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Assign Action') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="action_id" aria-label="Default select example">
                                    @foreach($actions as $action)
                                    <option value="{{ $action->id }}" @if($customer->action_id == $action->id)selected="selected"@endif >{{ $action->action_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
                    {{ __('This page is open only for admins and employees!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endhasanyrole
@endsection