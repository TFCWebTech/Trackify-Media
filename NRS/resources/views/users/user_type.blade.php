@include('common\header')

<!-- Include the necessary CSS and JS libraries for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<style>
table.dataTable th,
table.dataTable td {
  white-space: nowrap;
}
.dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select{
padding: 2px !important;
margin-bottom: 5px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button{
    padding: .2em .3em !important;
}
.form-group {
    margin-bottom: 0rem !important;
}
.modal-body{
    padding: 0rem .5rem .5rem .5rem  !important;
}
</style>
<div class="container">
        <div class="row">
             <div class="col-md-12">
             @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        {{ session('error') }}
                    </div>
                @endif


    
             </div>
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add User Type</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-hover dt-responsive">
                <thead >
                <tr>
                    <th>Sr.No</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $sr_no = 0; ?>
                    @foreach($user_type_data as $values)
                        <?php $sr_no++; ?>
                        <tr>
                            <td>{{ $sr_no }}</td>
                            <td>{{ $values->user_type }}</td>
                            @if($values->user_type_status == 1)
                                <td> <i class="bg-primary px-2 text-light">Active</i></td>
                            @else
                                <td> <i class="bg-danger px-2 text-light ">InActive</i></td>
                            @endif
                            <td>{{ $values->created_at->format('d F Y') }}</td>
                            <td>
                                &nbsp; <i class="fa fa-edit text-primary" onclick="editUserType('{{ $values->user_type_id }}')" data-toggle="modal" data-target="#editModal" title="Edit"></i>&nbsp; 
                                <i class="fa fa-trash text-danger" onclick="deleteUserType('{{ $values->user_type_id }}')" data-toggle="modal" data-target="#deleteModal" title="Delete"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
</div>

<!-- The Add Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add User Type</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="{{route('add_userType')}}" method="post">
            @csrf
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">User Type </label>
                    <input type="text" class="form-control" placeholder="Enter User Type" name="user_type" required>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="text-right pt-2">
                 <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit User Type</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="{{route('edit_userType')}}" method="post">
            @csrf
                <div class="form-group">
                    <input type="text" name="user_type_id" id="user_type_id" hidden>
                    <label class="px-1 font-weight-bold" for="user_type">User Type </label>
                    <input type="text" class="form-control" placeholder="Enter User Type" id="user_type" name="user_type" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Status </label>
                    <select class="form-control" name="user_type_status" id="user_type_status">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="text-right pt-2">
                 <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete User </h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
            <form action="{{route('delete_userType')}}" method="post">
            @csrf
                <div class="form-group">
                    <p class="px-2">Do you really want to delete ?</p>
                    <input type="text" name="user_type_id" id="delete_user_type_id" hidden >
                </div>
                <div class="text-right pt-2">
                 <button type="submit" class="btn btn-primary">YES</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $('table').DataTable();

    function editUserType(user_type_id) {
    var user_type_data = <?php echo json_encode($user_type_data); ?>;
    // console.log('User type data:', user_type_data);
    
    for (var i = 0; i < user_type_data.length; i++) {
        // Check if the current object's question_id matches the desired question_id
        if (user_type_data[i].user_type_id == user_type_id) {
            // If a match is found, store the object in desiredTask and break out of the loop
            desiredData = user_type_data[i];
            $('#user_type_id').val(desiredData.user_type_id);
            $('#user_type').val(desiredData.user_type);
            $('#user_type_status').val(desiredData.user_type_status);
            break;
        }
    }

}

     function deleteUserType(user_type_id){
        var user_type_data = <?php echo json_encode($user_type_data); ?>;
        console.log('User type data:', user_type_data);
        
        for (var i = 0; i < user_type_data.length; i++) {
            // Check if the current object's question_id matches the desired question_id
            if (user_type_data[i].user_type_id == user_type_id) {
                // If a match is found, store the object in desiredTask and break out of the loop
                desiredData = user_type_data[i];
                $('#delete_user_type_id').val(desiredData.user_type_id);
                break;
            }
        }
    }
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')