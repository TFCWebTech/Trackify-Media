@include('common/header')

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
/* @media (min-width: 768px) { */
        .table-container-responsive{
            overflow-x: auto;
        }
    /* } */
    dl, ol, ul {
    margin-top: 0;
    margin-bottom: 0rem !important;
}
</style>
<div class="container">
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
@endif
          <div class="col-md-12 text-right p-2">
                  <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h5 mb-0 text-gray-800 ">Manage Reporter</h1>
              <button class="btn btn-primary" onclick="addReporter()">Add Reporter</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Reporter Name</th>
                        <th>Reporter Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach($reporters as $reporter)
                        <?php $i++; ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $reporter->user_name }}</td>
                            <td>{{ $reporter->user_email }}</td>
                            <td>
                                @if($reporter->user_status == 0)
                                    Inactive
                                @else
                                    Active
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($reporter->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <i class="fa fa-edit text-primary" onclick="editReporter({{ json_encode($reporter) }})"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div></div>

<!-- The Modal -->
<div class="modal fade" id="reporterInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Reporter</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="reporterForm" method="POST" action="{{ route('reporter.store') }}">
          @csrf
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_reporter_name">Reporter Name</label>
            <input type="text" class="form-control" placeholder="Enter Reporter Name"  name="update_reporter_name" required>
          </div>
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
            placeholder="Enter Email" name="email" id="update_email" required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_status">Status</label>
            <select class="form-control" name="status" id="update_status" required>
              <option value="">Select Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div class="text-right pt-2">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
 function editReporter(reporter) {
    $('#modal-title').text('Update Reporter');
    $('#reporterForm').attr('action', `/NRS/reporter/update/${reporter.user_id}`);
    
    // Populate the form fields with the reporter data
    $('input[name="update_reporter_name"]').val(reporter.user_name);
    $('input[name="email"]').val(reporter.user_email);
    $('select[name="status"]').val(reporter.user_status);
    
    // Show the modal
    $('#reporterInfo').modal('show');
  }

  function addReporter() {
    $('#modal-title').text('Add Reporter');
    $('#reporterForm').attr('action', '{{ route('reporter.store') }}');
    $('#reporterForm').trigger('reset');
    $('#reporterInfo').modal('show');
  }
</script>

<script>
    $('table').DataTable();
</script>
</div>

            <!-- End of Main Content -->
@include('common/footer')