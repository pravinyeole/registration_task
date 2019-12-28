@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome Super Admin</div>

                <div class="panel-body">
                     <div class="panel-body">
                    <table class="table">
                        <?php $i = 1; ?>
                        <tr>
                            <th>Sr.no</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>    
                        </tr>
                        @foreach($data as $key=>$val)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$val['first_name']}}</td>
                                <td>{{$val['last_name']}}</td>
                                <td>{{$val['email']}}</td>
                                <td>{{$val['phone']}}</td>
                                <td>{{ucfirst($val['role']['name'])}}</td>
                            </tr>
                            <?php $i++; ?>
                       @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
