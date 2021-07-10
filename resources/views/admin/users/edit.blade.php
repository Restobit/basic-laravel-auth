@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{$user->name}}</h1>
        </div>
        <div class="row ">
            <div class="col-8">
                {{Form::open(['url'=>route('admin.users.update',$user),"method"=>'PUT']) }}
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        {{Form::text('name',$user->name,['class'=>'form-control '.($errors->has('name') ? "is-invalid":""),'required'])}}
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                    <div class="col-md-6">
                        {{Form::email('email',$user->email,['class'=>'form-control '.($errors->has('email') ? "is-invalid":"")])}}
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                @if(env('MUST_ACCEPT_USER_REGISTRATION'))
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                        <div class="col-md-6">
                            {{Form::select('accepted',$statuses,$user->accepted,['class'=>'form-control '.($errors->has('accepted') ? "is-invalid":"")])}}
                            @error('accepted')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                    <div class="col-md-6">
                        <select name="roles[]" id="roles"
                                class="form-control {{($errors->has('roles') ? 'is-invalid':'')}}" multiple="multiple">
                            @foreach($roles as $id => $roles)
                                <option
                                    value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ __('roles.'.$id) }}</option>
                            @endforeach
                        </select>

                        @if($errors->has('roles'))
                            <span class="invalid-feedback" role="alert">
                            <strong> {{ $errors->first('roles') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-10">
                        {{Form::submit(__('Save'),['class'=>'btn btn-success float-right'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
