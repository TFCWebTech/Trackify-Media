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
 @media (min-width: 768px) { */
        .table-container-responsive{
            overflow-x: hidden;
        } 
     } 

     dl, ol, ul {
    margin-top: 0;
    margin-bottom: 0rem !important;
}
</style>

<div class="container-fluid">
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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h5 mb-0 text-gray-800 ">Manage Edition</h1>
                    <button class="btn btn-primary" onclick="addEdition()">Add Edition</button>
                </div>
            </div>
        </div>
             <div class="row justify-contain-center">
                <div class="col-md-12">
                  <div class="table table-container-responsive">
                    <table class="table table-bordered table-hover">
                       <thead>
                       <tr>
                        <th>Sr. No</th>
                        <th>Edition Name</th>
                        <th>Edition Order</th>
                        <th>Publication</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                   </thead>
                   <tbody>
                    <?php $i = 0 ;?>
                   @foreach($editions as $edition)
                   <?php $i++ ;?>
                   <tr>
                        <td>{{$i}}</td>
                       <td>{{ $edition->Edition }}</td>
                       <td>{{ $edition->EditionOrder }}</td>
                       <td>{{ $edition->media_outlet_name }}</td>
                       <td>
                           @if($edition->Status == 0)
                               Inactive
                           @else
                               Active
                           @endif
                       </td>
                       <td>{{ \Carbon\Carbon::parse($edition->CreatedOn)->format('d/m/Y') }}</td>
                       <td>
                           <i class="fa fa-edit text-primary" onclick="editEdition('{{ json_encode($edition) }}')"></i>
                       </td>
                   </tr>
                   @endforeach
                   </tbody>
                </table>
            </div>
         </div>
         </div>
        </div>
        

<!-- The Modal -->
<div class="modal fade" id="editionInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Edition</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="editionForm" method="POST" action="{{ route('edition.store') }}">
          @csrf
          <div class="form-group">
                    <label class="px-1 font-weight-bold" for="edition_name">Edition Name </label>
                    <input type="text" class="form-control" placeholder="Enter Edition Name" id="Edition" name="Edition" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="EditionOrder">Edition Order</label>
                    <input type="text" class="form-control" placeholder="Enter Edition Order" id="EditionOrder" name="EditionOrder" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="tier_type">Publication</label>
                    <select class="form-control" name="MediaOutletId" id="MediaOutletId" required>
                        <option value="">Select</option>
                        @foreach($publication as $pub)
                            <option value="{{ $pub->gidMediaOutlet }}">{{ $pub->MediaOutlet }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="update_status">Status</label>
                    <select class="form-control" name="Status" id="Status" required>
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>   
                </div>
                <input type="hidden" name="CreatedBy">
                <input type="hidden" name="CreatedOn">
                <input type="hidden" name="gidEdition">
                <div class="text-right pt-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

function editEdition(edition) {
    const editionobject = JSON.parse(edition);
    console.log('edition data:', editionobject);
   
    $('#modal-title').text('Update Edition');
    $('#editionForm').attr('action', `/Edition/update/${editionobject.gidEdition_id}`);

    // Populate the form fields with the supplement data
    $('input[name="Edition"]').val(editionobject.Edition);
    $('input[name="EditionOrder"]').val(editionobject.EditionOrder);
    $('select[name="MediaOutletId"]').val(editionobject.MediaOutletId);
    $('select[name="Status"]').val(editionobject.Status);
    $('input[name="CreatedBy"]').val(editionobject.CreatedBy);
    $('input[name="CreatedOn"]').val(editionobject.CreatedOn); 
    $('input[name="gidEdition"]').val(editionobject.gidEdition); 
    // Show the modal
    $('#editionInfo').modal('show');
}
  function addEdition() {
    $('#modal-title').text('Add Edition');
    $('#editionForm').attr('action', '{{ route('edition.store') }}');
    $('#editionForm').trigger('reset');
    $('#editionInfo').modal('show');
  }

    $('table').DataTable();

</script>

</div>

<!-- End of Main Content -->
@include('common\footer')