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
              <div class="alert alert-danger">
                  <ul>
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
             @endif

             @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        <div class="row">
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Edition</button>
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
                           <i class="fa fa-edit text-primary" onclick="edit('{{ $edition->Edition }}')"></i>
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
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Edition</h4>
              <!-- Correct close button for Bootstrap 4 -->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
            <form id="addEditionForm" action="{{ route('edtion.addEdition') }}" method="post">
            @csrf
            <div class="form-group">
            <label for="Edition">Edition Name:</label>
            <input type="text" class="form-control" placeholder="Edition Name" name="Edition" id="Edition" value="{{ old('Edition') }}" required>
            @error('Edition')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="EditionOrder">Edition Order:</label>
            <input type="text" class="form-control" placeholder="Edition Order" name="EditionOrder" id="EditionOrder" value="{{ old('EditionOrder') }}" required>
            @error('EditionOrder')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="MediaOutletId">Publication:</label>
            <select class="form-control" name="MediaOutletId" id="MediaOutletId" required>
                <option value="">Select</option>
                @foreach($publication as $pub)
                    <option value="{{ $pub->gidMediaOutlet }}" {{ old('MediaOutletId') == $pub->gidMediaOutlet ? 'selected' : '' }}>{{ $pub->MediaOutlet }}</option>
                @endforeach
            </select>
            @error('MediaOutletId')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="Status">Status:</label>
            <select class="form-control" name="Status" id="Status" required>
                <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Inactive</option>
                <option value="1" {{ old('Status') == '1' ? 'selected' : '' }}>Active</option>
            </select>
            @error('Status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12 text-right mt-2">
        <button type="submit" class="btn btn-primary">Add Edition</button>
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
        <h4 class="modal-title">Edit Edition</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
      <form  action="{{ route('edition.update') }}" method="post">
      @csrf
      @method('PUT')
       <input type="text" name="edition_id" id="edition_id" hidden />
        <div class="form-group">
            <label class="px-1 font-weight-bold" for="publiction_name">Edition Name </label>
            <input type="text" class="form-control" placeholder="Enter Edition Name" name="Edition" id="old_Edition" required>
        </div>

        <div class="form-group">
            <label class="px-1 font-weight-bold" for="publiction_order">Edition Order </label>
            <input type="text" class="form-control" placeholder="Enter Edition Order" id="old_EditionOrder" name="EditionOrder" required>
        </div>

        <div class="form-group">
          <label class="px-1 font-weight-bold" for="media_outlet">Publication </label>
          <select class="form-control" name="MediaOutletId" id="old_publication" required>
                <option value="">Select</option>
                @foreach($publication as $pub)
                    <option value="{{ $pub->gidMediaOutlet }}">{{ $pub->MediaOutlet }}</option>
                @endforeach
          </select>
      </div>

        <div class="form-group">
            <label class="px-1 font-weight-bold" for="MediaOutletId">Status </label>
            <select class="form-control" name="Status" id="old_Status">
                <option value="">Select</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
                <!-- Add options dynamically if needed -->
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
    $('table').DataTable();

    function edit(Edition) {
      var all = <?php echo json_encode($editions); ?>;
      // alert(gidEdition);
      // console.log(all+' all data');
      var desiredTask = null;
			// Loop through all_questions array
			for (var i = 0; i < all.length; i++) {
				// Check if the current object's question_id matches the desired question_id
				if (all[i].Edition == Edition) {
					// If a match is found, store the object in desiredTask and break out of the loop
					desiredTask = all[i];
					break;
				}
			}
      console.log(desiredTask);
      $('#edition_id').val(desiredTask.edition_id);
      $('#old_Edition').val(desiredTask.Edition);
      $('#old_EditionOrder').val(desiredTask.EditionOrder);
      $('#old_publication').val(desiredTask.MediaOutletId);
      $('#old_Status').val(desiredTask.Status);
      $('#editModal').modal('show');
    }

</script>

</div>

<!-- End of Main Content -->
@include('common\footer')