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
    input.setAttribute('required', 'required');

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
              <h1 class="h5 mb-0 text-gray-800 ">Manage Client</h1>
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Client</button>
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
                    <th>Client Name</th>
                    <th>Keywords</th>
                    <th>Status</th>
                    <th>Add User Email</th>
                    <th>Add Competitor</th>
                    <!-- <th>Created At</th> -->
                    <th> Email Template</th>
                    <!-- <th>Action</th> -->
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 0; ?>
                    @foreach($clients as $values)
                    <?php $i++; ?>
                <tr>
                    <td>{{ $values -> client_name}}</td>
                    <td>{{ $values -> client_keywords}}</td>
                    @if ($values -> cilent_status == '1')
                        <td> <i class="text-primary font-weight-bold "> Active</i></td>
                    @elseif ($values -> cilent_status == '0')
                        <td> <i class="text-danger font-weight-bold "> InActive</i></td>
                    @else
                        <td>NA</td>
                    @endif
                    <td class="text-center"><a class="btn btn-primary" onclick="addEmail('{{$values ->client_id }}')" > ADD</a></td>
                    <td class="text-center"><a class="btn btn-primary" onclick="addCompetotor('{{$values ->client_id }}')" > ADD</a></td>
                    <td class="text-center">
                      <a class="btn btn-primary" href="{{ route('addNewsTemplate', ['client_id' => $values->client_id]) }}"> ADD</a>
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
<div class="modal" id="myModal">
  <div class="modal-dialog ">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Client</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
            <form onsubmit="return validateForm()" action="{{route('client.store')}}" method="post">
            @csrf
             <div class="row">
                <div class="col-md-12">
                    <label class="px-1 font-weight-bold" for="user_type">Client Name </label>
                    <input type="text" class="form-control" placeholder="Enter Client Name" name="client_name" required>
                </div>
                <div class="col-md-12">
                    <label class="px-1 font-weight-bold" for="is_active">Status</label>
                    <select name="is_active" class="form-control">
                        <option >Select</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="px-1 font-weight-bold" for="Sector">Sector</label>
                    <select name="Sector" class="form-control">
                        <option >Select</option>
                    </select>
                </div>
            
                <div class="col-md-12" id="additionalKeywords">
                    <label class="px-1 font-weight-bold" for="user_type">Add Keywords</label>
                    <input type="text" class="form-control" placeholder="Enter Keywords" name="Keywords[]" required>
                <!-- </div> -->
                </div>
                <div id="additionalKeywords"></div>
                <div class="col-md-12 text-right pt-2">
                    <p onclick="addKeywordInput()"><i class="text-primary cursor"><u> Add More Keywords</u> </i></p>
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<div class="modal fade" id="addCompitetor" tabindex="-1" role="dialog" aria-labelledby="addCompitetorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="addCompitetorLabel">Add Competitor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form  action="{{route('client.addCompetitor')}}" method="post">
         @csrf
          <div class="form-group">
            <input type="text" id="client_id" name="client_id" hidden>
            <label for="Competitor_name">Competitor Name</label>
            <input type="text" class="form-control" placeholder="Enter Competitor Name" name="Competitor_name" required>
          </div>
          <div class="form-group">
            <label for="is_active">Status</label>
            <select name="is_active" class="form-control">
              <option>Select</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div class="form-group" id="additionalKeywords2">
            <label for="CompetetorKeywords">Add Keywords</label>
            <input type="text" class="form-control" placeholder="Enter Keywords" name="CompetetorKeywords[]" required>
          </div>
          <div class="text-right pt-2">
            <p onclick="addKeywordInput2()"><i class="text-primary cursor"><u> Add More Keywords</u></i></p>
            <button type="submit" class="btn btn-primary">ADD</button>
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