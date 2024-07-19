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
        <div class="row">
            <div class="col-md-12 text-right p-2">
            <button class="btn btn-primary" onclick="addJournalist()">Add Journalist</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Journalist Name</th>
                            <th>Journalist Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                         $i = 0; ?>
                            @foreach($journalists as $journalist)
                            <?php $i++; 
                           ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$journalist -> Journalist}}</td>
                            <td>{{$journalist -> JEmailId}}</td>
                            <td>  @if($journalist ->Status == 0)
                                    Inactive
                                @else
                                    Active
                                @endif
                             </td>
                          
                          <td>{{ \Carbon\Carbon::parse($journalist->CreatedOn)->format('d/m/Y') }}</td>
                          <td>
                          <i class="fa fa-edit text-primary" onclick="editJournalist({{ json_encode($journalist) }})"></i>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div></div>

<!-- The Modal -->
<div class="modal fade" id="journalistInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Journalist</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="JournalistForm" method="POST" action="{{ route('journalist.store') }}">
          @csrf
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_reporter_name">Journalist Name</label>
            <input type="text" class="form-control" placeholder="Enter Journalist Name"  name="journalist_name" required>
          </div>
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_email">Email</label>
            <input type="email" class="form-control" placeholder="Enter Journalist email"  name="journalist_email" required>
            </div>
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="update_status">Status</label>
            <select class="form-control" name="journalist_status" id="journalist_status" required>
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
 function editJournalist(journalist) {
    $('#modal-title').text('Update Journalist');
    $('#JournalistForm').attr('action', `/journalist/update/${journalist.journalist_id}`);
    
    // Populate the form fields with the reporter data
    $('input[name="journalist_name"]').val(journalist.Journalist);
    $('input[name="journalist_email"]').val(journalist.JEmailId);
    $('select[name="journalist_status"]').val(journalist.Status);
    
    // Show the modal
    $('#journalistInfo').modal('show');
  }

  function addJournalist() {
    $('#modal-title').text('Add Journalist');
    $('#JournalistForm').attr('action', '{{ route('journalist.store') }}');
    $('#JournalistForm').trigger('reset');
    $('#journalistInfo').modal('show');
  }
</script>

<script>
    $('table').DataTable();
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')