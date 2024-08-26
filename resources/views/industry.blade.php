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
.cursor{
    cursor: pointer;
}


    .modal-footer{
        justify-content: flex-start !important; 
        display: block !important;
    }
.pointer{
cursor:pointer;
}
select.form-control[multiple], select.form-control[size] {
    height: 114px !important;
}
.select2-container{
	width:100% !important;
}
.select2 {
	width:100% !important;
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h5 mb-0 text-gray-800 ">Manage Industry</h1>
                        <button class="btn btn-primary" onclick="addIndustry()">Add Industry</button>
                    </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-hover dt-responsive">
                <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Industry Name</th>
                    <th>Company Name</th>
                    <th>Keywords</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php $i = 0; ?>
                @foreach($industries as $industrys)
                <?php $i ++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $industrys -> Industry_name}}</td>
                        <td>
                            @if (!empty($industrys->client_names))
                                {{ $industrys->client_names }}
                            @else
                                No clients available
                            @endif
                        </td>
                        <td>{{ $industrys -> Keywords}}</td>
                        @if ($industrys->is_active == '1')
                            <td><i class="text-primary font-weight-bold">Active</i></td>
                        @elseif ($industrys->is_active == '0')
                            <td><i class="text-danger font-weight-bold">Inactive</i></td>
                        @else
                            <td>NA</td>
                        @endif
                        <td>
                        <i class="fa fa-edit text-primary" onclick="editIndustry({{ json_encode($industrys) }})"></i>
                        </td>
                </tr>
                @endforeach
                </tbody>
            
            </table>
            </div>
        </div>
</div>

<!-- The Modal -->
<div class="modal" id="IndustryInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Industry</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
            <form id="IndustryForm" action="{{ route('Industry.store') }}" method="POST">
            @csrf
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Industry Name </label>
                    <input type="text" class="form-control" placeholder="Enter Industry Name" name="Industry_name" required>
                </div>
                <div class="form-group">
                  <label class="px-1 font-weight-bold" for="update_status">Status</label>
                  <select class="form-control" name="status" id="update_status" required>
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="is_active">Add Clients</label>
                    <select class="js-example-basic-multiple form-control" name="client_name[]" id="client_name" multiple="multiple">
                        <option disabled>Select</option>
                        @foreach ($clients as $values)
                            <option value="{{$values -> client_id}}"> {{$values -> client_name}}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="is_active">Add Competitors</label>
                    <select class="js-example-basic-multiple form-control" name="compitertors_name[]" id="compitertors_name" multiple="multiple">
                        <option disabled>Select</option>
                        @foreach ($competitors as $values)
                            <option value="{{$values -> competitor_id}}"> {{$values -> Competitor_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="keyFiled">
            <label class="px-1 font-weight-bold" for="user_type">Add Keywords</label>
            <input type="text" class="form-control keyword-input" placeholder="Enter Keywords" name="Keywords[]">
          </div>
          <div id="additionalKeywords"></div>
          <div class="form-group text-right pt-2" id="moreFiled">
            <p onclick="addKeywordInput()"><i class="text-primary cursor"><u> Add More Keywords</u></i></p>
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
  function editIndustry(industrys) {
    console.log(industrys);
    $('#modal-title').text('Update Industry');
    $('#IndustryForm').attr('action', `/NRS/industry/update/${industrys.Industry_id}`);
    
    // Populate the form fields with the industry data
    $('input[name="Industry_name"]').val(industrys.Industry_name);
    $('select[name="status"]').val(industrys.is_active);
    
    // Clear previous selections for multiple select fields
    $('select[name="client_name[]"]').val(null).trigger('change');
    $('select[name="compitertors_name[]"]').val(null).trigger('change');
    
    // Set the new values for multiple select fields
    if (industrys.client_id) {
        let clientIds = industrys.client_id.split(',').map(Number);
        $('select[name="client_name[]"]').val(clientIds).trigger('change');
    }
    if (industrys.competitor_id) {
        let competitorIds = industrys.competitor_id.split(',').map(Number);
        $('select[name="compitertors_name[]"]').val(competitorIds).trigger('change');
    }

    // Hide keyword fields for edit functionality
    $('#keyFiled').hide();
    $('#moreFiled').hide();
    $('#additionalKeywords').hide();
    
    $('#IndustryInfo').modal('show');
  }

  function addIndustry() {
    $('#modal-title').text('Add Industry');
    $('#IndustryForm').attr('action', '{{ route('Industry.store') }}');
    $('#IndustryForm').trigger('reset');
    
    // Show keyword fields for add functionality
    $('#keyFiled').show();
    $('#moreFiled').show();
    
    $('#IndustryInfo').modal('show');
  }

  function addKeywordInput() {
    var formGroup = document.createElement('div');
    formGroup.classList.add('form-group', 'keyword-group');

    var labelRow = document.createElement('div');
    labelRow.classList.add('d-flex', 'justify-content-between', 'mt-2');

    var label = document.createElement('label');
    label.classList.add('px-1', 'font-weight-bold', 'mr-2');
    label.setAttribute('for', 'user_type');
    label.textContent = 'Add Keywords';

    var removeIcon = document.createElement('i');
    removeIcon.classList.add('fa', 'fa-trash', 'text-danger', 'cursor-pointer');
    removeIcon.style.cursor = 'pointer';
    removeIcon.onclick = function() {
        formGroup.remove();
    };

    labelRow.appendChild(label);
    labelRow.appendChild(removeIcon);

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.classList.add('form-control');
    input.setAttribute('placeholder', 'Enter Keywords');
    input.setAttribute('name', 'Keywords[]');

    formGroup.appendChild(labelRow);
    formGroup.appendChild(input);

    var parentDiv = document.getElementById('additionalKeywords');
    parentDiv.appendChild(formGroup);
  }
    $('table').DataTable();
</script>
</div>
@include('common/footer')
            <!-- End of Main Content -->    