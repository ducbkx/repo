@extends('layouts.app')

@section('content')
<div class="col-xs-8 col-xs-offset-2" style="margin-top: 50px;">
    <table class="table table-hover">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Action</td>
        </tr>
        @foreach ($divisions  as $division)
        <tr>
            <td>{{ $division->id }}</td>
            <td>{{ $division->name }}</td>
            <td>
                <a class="btn btn-primary" href="division/{{ $division->id }}/edit">Edit</a>
                <a class="btn btn-danger" href="division/{{ $division->id }}/delete">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div style="display:flex; justify-content:center;align-items:center;">
      {{ $divisions->links() }}
      </div>
</div>
@endsection