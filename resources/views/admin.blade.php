@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome Admin</div>
                
                <div class="panel-body">
                   <table class="table">
                    <?php $i = 1; ?>
                        <tr>
                            <th>Sr.no</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>    
                        </tr>
                       @foreach($data as $key=>$val)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$val['first_name']}}</td>
                                <td>{{$val['last_name']}}</td>
                                <td>{{$val['email']}}</td>
                                <td>{{$val['phone']}}</td>
                                @if(Auth::user()->id == $val['id'])
                                    <td><input type="button" name="edit" class="btn btn-primary edit_text" value="Edit" id_edit = "{{$val['id']}}" first_name = "{{$val['first_name']}}" last_name = "{{$val['last_name']}}" email = "{{$val['email']}}" phone = "{{$val['phone']}}"/></td>
                                @endif
                            </tr>
                            <?php $i++; ?>
                       @endforeach
                   </table>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <span>First Name : <input type="text" name="first_name" class="form-control first_name"><input type="hidden" name="first_name" class="form-control id_row"></span><br>
                                <span>Last Name : <input type="text" name="last_name" class="form-control last_name"></span><br>
                                <span>Email : <input type="text" name="email" class="form-control email"></span><br>
                                <span>Phone Number : <input type="text" name="phone" class="form-control phone"></span><br>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary save">Save</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).on('click', '.edit_text', function(event) {
    $('#myModal').modal('show');
    var first_name =  $(this).attr("first_name");
    var last_name =  $(this).attr("last_name");
    var email =  $(this).attr("email");
    var phone =  $(this).attr("phone");
    var id =  $(this).attr("id_edit");
    
    $('.first_name').val(first_name);
    $('.last_name').val(last_name);
    $('.email').val(email);
    $('.phone').val(phone);
    $('.id_row').val(id);
});



$(document).on('click', '.save', function(event) {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    first_name = $('.first_name').val();
    last_name = $('.last_name').val();
    email = $('.email').val();
    phone = $('.phone').val();
    id_row = $('.id_row').val();

    $.ajax({ 
         url: "{{url('/update')}}",
         data: {'first_name': first_name,'last_name':last_name,'email':email,'phone':phone,'id':id_row},
         type: 'post',
         success: function(output) {
                      alert(output.msg);
                      $('#myModal').modal('hide');
                      location.reload();
                  }
        });
});
</script>
@endsection

