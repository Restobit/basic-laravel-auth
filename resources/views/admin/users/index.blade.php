@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{__('Users')}}</h1>
            <a href="{{route('admin.users.create')}}" class="btn btn-info float-right">{{__('Create new user')}}</a>
        </div>

        <div class="row">
            <div class="col-12">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{__("Name")}}</th>
                        <th>{{__("Email")}}</th>
                        <th>{{__("Role")}}</th>
                        @if(env('MUST_ACCEPT_USER_REGISTRATION'))
                            <th>{{__("Status")}}</th>
                        @endif
                        <th>{{__("Edit")}}</th>
                        <th>{{__("Delete")}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__("Name")}}</th>
                        <th>{{__("Email")}}</th>
                        <th>{{__("Role")}}</th>
                        @if(env('MUST_ACCEPT_USER_REGISTRATION'))
                            <th>{{__("Status")}}</th>
                        @endif
                        <th>{{__("Edit")}}</th>
                        <th>{{__("Delete")}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->getRolesString()}}</td>
                            @if(env('MUST_ACCEPT_USER_REGISTRATION'))
                                <td>{{$statuses[$user->accepted]}}</td>
                            @endif
                            <td><a class="btn btn-info btn-block"
                                   href="{{route('admin.users.edit',$user)}}">{{__("Edit")}}</a>
                            </td>
                            <td><a class="btn btn-danger btn-block"
                                   onclick="event.preventDefault();
                                       document.getElementById('delete-form-{{$user->id}}').submit();">{{__("Delete")}}</a>
                                {{Form::open(['url'=>route('admin.users.destroy',$user),'method'=>'delete','id' =>'delete-form-'.$user->id])}}
                                {{Form::close()}}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


@endsection
