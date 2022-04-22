@extends('layouts.app')

@section('content')
@role('admin')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Employee') }}</div>
                <div class="card-body">

                    <form method="POST" action="{{ route('employees.update',$employee['id']) }}">
                        @csrf
                        {{ method_field('PUT') }}

                        <input  type="text" name="user_id" value="{{ $employee['user_id'] }}" hidden>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $employee['name'] }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $employee['email'] }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="starting_date" class="col-md-4 col-form-label text-md-end">{{ __('starting date') }}</label>

                            <div class="col-md-6">
                                <input id="starting_date" type="text" class="form-control @error('starting_date') is-invalid @enderror" name="starting_date" value="{{ $employee['starting_date'] }}" required autocomplete="starting_date" autofocus>

                                @error('starting_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Assign Customers') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="customer_id[]"  multiple aria-label="Default select example">
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"   @foreach($employee['customer_id'] as $id) @if($customer->id == $id)selected="selected"@endif @endforeach    >{{ $customer->name }}</option>
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
                    {{ __('This page is open only for admins!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection