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
             <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h5 mb-0 text-gray-800 ">Manage Supplement</h1>
                    <button class="btn btn-primary" onclick="addSupplement()">Add Supplement</button>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table class="table table-bordered table-hover ">
                <thead>
                <tr>
                    <th>Sr. no</th>
                    <th>Supplement Name</th>
                    <th>Edition </th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                  @foreach($supplements as $supplement)
                  <?php $i++; ?>
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{$supplement->Supplement}}</td>
                    <td>{{$supplement->edition_name}}</td>
                    <td>
                           @if($supplement->Status == 0)
                               Inactive
                           @else
                               Active
                           @endif
                       </td>
                       <td>{{ \Carbon\Carbon::parse($supplement->CreatedOn)->format('d/m/Y') }}</td>
                       <td> 
                           <i class="fa fa-edit text-primary" onclick="editSupplement('{{ json_encode($supplement) }}')"></i>
                       </td>
                </tr>
               @endforeach
                </tbody>
            
            </table>
            </div>
        </div>
</div></div>

<!-- The Modal -->
<div class="modal fade" id="supplementInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Supplement</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="supplementForm" method="POST" action="{{ route('supplement.store') }}">
          @csrf
          <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Supplement Name </label>
                    <input type="text" class="form-control" placeholder="Enter Supplement Name" id="Supplement_name" name="Supplement_name" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="tier_type">Publication</label>
                    <select class="form-control" name="MediaOutletId" id="MediaOutletId" onchange="change_publication(this.value)" required>
                        <option value="">Select</option>
                        @foreach($publication as $pub)
                            <option value="{{ $pub->gidMediaOutlet }}">{{ $pub->MediaOutlet }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="tier_type">Edition</label>
                    <select class="form-control" name="Edition" id="Edition">
                        <option value="">Select</option>    
                        <!-- Options will be dynamically populated -->
                    </select>
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
function editSupplement(supplement) {
    const supplementObject = JSON.parse(supplement);
    console.log('Supplement data:', supplementObject);
   
    $('#modal-title').text('Update Supplement');
    $('#supplementForm').attr('action', `/NRS/Supplement/update/${supplementObject.supplement_id}`);

    // Populate the form fields with the supplement data
    $('input[name="Supplement_name"]').val(supplementObject.Supplement);
    $('select[name="MediaOutletId"]').val(supplementObject.mediaOutlet);
    
    // Fetch and populate the editions based on the media outlet
    change_publication(supplementObject.mediaOutlet).then(() => {
        // Ensure the select box is updated after the publication options are populated
        $('select[name="Edition"]').val(supplementObject.gidEdition);
    });

    $('select[name="status"]').val(supplementObject.Status);
    // Show the modal
    $('#supplementInfo').modal('show');
}
  function addSupplement() {
    $('#modal-title').text('Add Supplement');
    $('#supplementForm').attr('action', '{{ route('supplement.store') }}');
    $('#supplementForm').trigger('reset');
    $('#supplementInfo').modal('show');
  }


  function change_publication(publication) {
    return $.ajax({
        type: "POST",
        url: "{{ route('supplements.getEditionByPublication') }}",
        dataType: 'json', // Ensure the response is parsed as JSON
        data: {
            publication: publication,
            _token: "{{ csrf_token() }}"  // Add CSRF token
        },
        success: function (data) {
            // Clear the existing options
            $("#Edition").html('');
            // Append new options from the response
            $("#Edition").append(data.options);
        },
        error: function (xhr, status, error) {
            console.error('Error: ' + error);
            console.log('Response: ' + xhr.responseText);
        }
    });
}
</script>
<script>
    $('table').DataTable();
</script>
</div>

            <!-- End of Main Content -->
@include('common/footer')