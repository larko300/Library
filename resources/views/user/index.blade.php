@extends('layouts.app')

@section('content')
    @include('navbar')
    <div class="row mb-3">
        <div class="col-md-12">
            <form class="form-inline" method="get" action="{{ route('user.index') }}">
                <input type="text" class="form-control mr-3 col-sm-4" placeholder="Search user by name or email" value="{{ request()->get('search') }}" name="search">
                <select name="filter" class="form-control col-sm-2 mr-3">
                    <option value="0">All</option>
                    <option value="verified" {{ request()->get('filter') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="not_verified" {{ request()->get('filter') == 'not_verified' ? 'selected' : '' }}>Not verified</option>
                </select>
                <select name="sort" class="form-control col-sm-2 mr-3">
                    <option value="0">New first</option>
                    <option value="email_asc" {{ request()->get('sort') == 'email_asc' ? 'selected' : '' }}>By email</option>
                    <option value="id_desc" {{ request()->get('sort') == 'id_desc' ? 'selected' : '' }}>Old first</option>
                    <option value="name_asc" {{ request()->get('sort') == 'name_asc' ? 'selected' : '' }}>By name</option>
                </select>
                <button class="btn btn-primary mr-3">Filter</button>
                <a href="{{ route('user.index') }}">Reset</a>
            </form>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('user.create') }}"><button type="button" class="btn btn-success float-right">Add</button><a/>
                    <h3>User manager</h3>
            </div>
            <div class="card-body">
                @include('success')
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    @foreach($users as $user)
                        <tbody>
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if($user->email_verified_at)
                                    verified
                                @else
                                    not verified
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}"><button type="submit" name="ban" class="btn btn-warning" value="">Edit</button></a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center pt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
