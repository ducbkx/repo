@extends('layouts.app')

@section('content')
<div class="col-xs-8 col-xs-offset-2" style="margin-top: 50px;">
    <table class="table table-hover">
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Avatar</td>
            <td>Gender</td>
            <td>Code</td>
            <td>Division</td>
            <td>Role</td>
            <td>Action</td>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><image src="../storage/app/{{ $user->avatar }}"></td>
            <td>{{ $user->gender !== null ? $genders[$user->gender] : ''}}</td>
            <td>{{ $user->code }}</td>

            <td>{{ $user->division_id ? $divisions[$user->division_id]['name'] : '' }}</td>

            <td>{{ $user->role !== null ? $roles[$user->role] : ''}}</td>
            <td>
                <a class="btn btn-primary" href="user/{{ $user->id }}/edit">Edit</a>
                <a class="btn btn-danger btn-delete" href="user/{{ $user->id }}/delete">Delete</a>
                <a class="btn btn-primary" href="user/{{ $user->id }}/reset">Reset</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div style="display:flex; justify-content:center;align-items:center;">
      {{ $users->links() }}
      </div>

</div>
@endsection

@section('js')
    <script type="text/javascript">
        $('.btn-delete').on('click', function (e) {
           e.preventDefault();
           var confirmed = confirm('Are you sure delete this employee');
           var url = $(this).attr('href');
           if (confirmed) {
               return window.location.replace(url);
           }
        });
    </script>
@endsection