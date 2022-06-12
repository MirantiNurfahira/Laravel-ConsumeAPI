@extends('users.layout')
     
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Consume Rest API</h2>
                <div class="card-tools">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Create</a>
                        </div>
    </div>
    <table class="table table-bordered">
    <tr >
         <td>No</td>
         <td>FirstName</td>
         <td>LastName</td>
         <td>Action</td>
     </tr>
<tbody>

    @php
        $number = 1;
    @endphp
    @forelse($users['data'] as $user)
    @php
        $user_id = $user['id'];
    @endphp
    <tr>
        <td>{{ $number++ }}</td>
        <td>{{ $user['firstName'] }}</td>
        <td>{{ $user['lastName'] }}</td>
        <td align="center">
            <form action="{{route('users.destroy', $user['id'])}}" method="POST" id="delete_{{$user_id}}">
            <a href="{{ 'users/'.$user['id'] }}" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> 
            @csrf
            @method('DELETE')
            <button type="submit" class="text-danger" onClick="return confirm('Are you sure to delete this user?'); document.getElementById('delete_{{$user_id}}')"><i class="fa fa-fw fa-trash"></i> Delete</button>
            </form>
        </td>

    </tr>
    @empty
        <tr><td colspan="6" align="center">No Record(s) Found!</td></tr>
    @endforelse
</tbody>
</table>

@endsection