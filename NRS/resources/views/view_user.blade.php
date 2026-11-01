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
.hidden {
    display: none;
}
.table-container-responsive{
    overflow-x: auto;
}
label {
    margin-bottom: 0rem !important;
    margin-top: 0.0rem !important;
}
</style>

<script>
 function addKeywordInput(existingKeyword = '') {
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
    input.setAttribute('required', 'required');
    input.value = existingKeyword; // Set the value if provided

    formGroup.appendChild(labelRow);
    formGroup.appendChild(input);

    var parentDiv = document.getElementById('additionalKeywords');
    parentDiv.appendChild(formGroup);
}
</script>

<script>
function addKeywordInput2() {
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
    input.setAttribute('name', 'CompetetorKeywords[]');
    input.setAttribute('required', 'required');

    formGroup.appendChild(labelRow);
    formGroup.appendChild(input);

    var parentDiv = document.getElementById('additionalKeywords2');
    parentDiv.appendChild(formGroup);
}

</script>
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
            <h1 class="h5 mb-0 text-gray-800 ">Manage User for {{ $client->client_name }}</h1>
                <!-- <button class="btn btn-primary" onclick="addClient()">Add Client</button> -->
                <td class="text-center"><a class="btn btn-primary" onclick="addEmail({{ $client->client_id }})">ADD EMAIL</a></td>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class=" table-container-responsive">
            <table class="table table-bordered table-hover">
            <!-- <table class="table table-bordered table-hover dt-responsive"> -->
                <thead >
                <tr>
                   
                    <th>User Email</th>
                   <th>Report Service</th>     
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 0; ?>
                    @foreach($allclients as $values)
                    <?php $i++; ?>
                <tr>
                   
                    <td>{{ $values -> email}}</td>
                    <td> {{ $values->report_service == 1 ? 'Yes' : 'No' }}</td>
                  
                   
                 
                    
               
                    <td>
            <!-- Store the JSON-encoded user data in the 'data-user' attribute -->
            <i class="fa fa-edit text-primary" 
       data-user="{{ json_encode($values) }}" 
       onclick="editUser(this)"></i>
        </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
        </div>
</div>

<div class="modal" id="editEmailModal" tabindex="-1" role="dialog" aria-labelledby="editUserMail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="editUserMail">Edit User Email</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="editEmailForm" method="POST" action="{{ route('editUsersEmail') }}">
          @csrf
          @method('PUT')

          <!-- Hidden Input for User ID -->
          <div class="form-group">
            <input type="hidden" id="editUserId" name="client_id">
          </div>

          <!-- Email Input -->
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="editUserEmail">Edit Email</label>
            <input type="email" class="form-control" id="editUserEmail" name="users_mails" placeholder="Enter Email" required>
          </div>

          <!-- Report Service Selection -->
          <div class="form-group mt-2">
            <label class="px-1 font-weight-bold" for="editReportService">Report Service</label>
            <div class="d-flex justify-content-start px-2">
              <div class="form-check">
                <input type="radio" class="form-check-input" id="editReportService1" name="report_service" value="1">
                <label class="form-check-label" for="editReportService1">YES</label>
              </div> 
              &nbsp;&nbsp;&nbsp;&nbsp;
              <div class="form-check">
                <input type="radio" class="form-check-input" id="editReportService2" name="report_service" value="0">
                <label class="form-check-label" for="editReportService2">NO</label>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-right pt-2">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>






<div class="modal" id="addEmail" tabindex="-1" role="dialog" aria-labelledby="addUserMail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="addUserMail">Add User Email <span id="client_name_1"></span> </h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
      <form action="{{ route('addUsersEmail') }}" method="post">
      @csrf
                <div class="form-group" >
                    <input type="text" id="client_id_1" name="client_id_1" hidden> 
                    <label class="px-1 font-weight-bold" for="user_mails">Add Email</label>
                    <input type="text" class="form-control" placeholder="Enter Email" name="client_email" required>
                </div>
                    <div class="form-group mt-2">
                        <label class="px-1 font-weight-bold" for="report_Service">Report Service </label>
                    <div class="d-flex justify-content-start px-2">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="report_service_1" name="report_service" value="1" checked>
                            <label class="form-check-label" for="report_service_1">YES</label>
                        </div> &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="report_service_2" name="report_service" value="0">
                            <label class="form-check-label" for="report_service_2">NO</label>
                        </div>
                    </div>
                </div>
                <div class="text-right pt-2">
                 <button type="submit" class="btn btn-primary">ADD</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    $('table').DataTable();

</script>

<script>
   function editUser(element) {
    const userData = JSON.parse(element.dataset.user);

    // Populate the form fields
    document.getElementById('editUserId').value = userData.client_id;
    document.getElementById('editUserEmail').value = userData.email;

    if (userData.report_service === 1) {
        document.getElementById('editReportService1').checked = true;
    } else {
        document.getElementById('editReportService2').checked = true;
    }

    // Show the modal
    $('#editEmailModal').modal('show');
}

  // Function to add more keyword inputs dynamically
  function addKeywordInputEdit() {
    let div = document.createElement('div');
    div.classList.add('form-group');
    div.innerHTML = '<input type="text" class="form-control" name="competitor_keywords[]" placeholder="Enter Keywords">';
    document.getElementById('editKeywords').appendChild(div);
  }
	
	
	
	function addClient() {
		$('#modal-title').text('Add Client');
		$('#clientsForm').attr('action', '{{ route('reporter.store') }}');
		$('#myModal').modal('show');
	  }

    function addCompetotor(client) {
    $('#client_id').val(client);

    $('#addCompitetor').modal('show'); // Use Bootstrap's modal method
}

    function addEmail(client , client_name){
        $('#client_id_1').val(client);
        $('#client_name_1').val(client_name);
        $('#addEmail').modal('show');
    }
</script>

</div>

@include('common/footer')