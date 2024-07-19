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
</style>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" onclick="addPublication()">Add Publication</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table class="table table-bordered table-hover ">
                <thead >
                <tr>
                    <th>Sr .No </th>
                    <th>Publication Name</th>
                    <th>MediaType</th>
                    <th>Publication Type</th>
                    <th>Tier Type</th>
                    <th>Publication Language</th>
                    <th>Master head</th>
                    <th>Priority</th>
                    <th>Newspaper Short Name</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 0;?>
                  @foreach ($Publication as $Publications)
                  <?php $i++ ;?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$Publications -> MediaOutlet}}</td>
                    <td>{{$Publications -> Media_type_name}}</td>
                    <td>{{$Publications -> publication_type}}</td>
                    <td>{{$Publications -> gidTier}}</td>
                    <td>{{$Publications -> Language}}</td>
                    <td>{{$Publications -> Masthead}}</td>
                    <td>{{$Publications -> Priority}}</td>
                    <td>{{$Publications -> ShortName}}</td>
                    <td>  @if($Publications -> Status == 0)
                                    Inactive
                                @else
                                    Active
                                @endif</td>
                    <td>{{ \Carbon\Carbon::parse($Publications->CreatedOn)->format('d/m/Y') }}</td>
                    <td>{{$Publications -> CreatedBy}}</td>
                    <td>
                      <i class="fa fa-edit text-primary" onclick="editPublication({{ json_encode($Publications) }})"></i>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div></div>

<!-- The Modal -->
<div class="modal" id="publicationInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Publication</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
            <form id="publicationForm" action="{{ route('publication.store') }}" method="POST">
            @csrf
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Publication Name </label>
                    <input type="text" class="form-control" placeholder="Enter Publication Name" name="publiction_name" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Media Type </label>
                    <select class="form-control" name="media_type" id="media_type" required>
                      <option value="">Select</option>
                      @foreach($mediaType as $media_types)
                          <option value="{{ $media_types->gidMediaType }}">{{ $media_types->MediaType }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Publication Type </label>
                    <select class="form-control" name="publicationType" id="publicationType" required>
                    <option value="">Select</option>
                      @foreach($publicationType as $Publication_types)
                          <option value="{{ $Publication_types->gidPublicationType }}">{{ $Publication_types->PublicationType }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <label class="px-1 font-weight-bold" for="tier_type">Tier Type </label>
                  <select class="form-control" name="tier_type" id="tier_type">
                    <option value="">Select</option>
                  </select>
                </div>
                <div class="form-group">
                <label class="px-1 font-weight-bold" for="tier_type">Publication Language </label>
                <select class="form-control" name="publication_language" id="publication_language">
                    <option value="">Select</option>
                                    <option value="English">English</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Marathi">Marathi</option>
                                    <option value="Gujarati">Gujarati</option>
                                    <option value="Punjabi">Punjabi</option>
                                    <option value="Urdu">Urdu</option>
                                    <option value="Konkani">Konkani</option>
                                    <option value="Bengali">Bengali</option>
                                    <option value="Tamil">Tamil</option>
                                    <option value="Telugu">Telugu</option>
                                    <option value="Malayalam">Malayalam</option>
                                    <option value="Kannada">Kannada</option>
                                    <option value="Assamese">Assamese</option>
                                    <option value="Kashmiri">Kashmiri</option>
                                    <option value="Manipuri">Manipuri</option>
                                    <option value="Sanskrit">Sanskrit</option>
                                    <option value="Sindhi">Sindhi</option>
                                    <option value="Bhojpuri">Bhojpuri</option>
                                    <option value="Orissa">Orissa</option>
                  </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Master Head </label>
                    <input type="text" class="form-control" placeholder="Enter Master Head" name="master_head" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Priority  </label>
                    <input type="text" class="form-control" placeholder="Enter Priority " name="Priority" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Newspaper Short Name </label>
                    <input type="text" class="form-control" placeholder="Enter Newspaper Short Name" name="Short_name" required>
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
    $('table').DataTable();
</script>
<script>
  function editPublication(Publication) {
    $('#modal-title').text('Update Publication');
    $('#publicationForm').attr('action', `/Publication/update/${Publication.user_id}`);
    
    // Populate the form fields with the reporter data
    $('input[name="publiction_name"]').val(Publication.MediaOutlet);
    $('input[name="email"]').val(Publication.user_email);
    $('select[name="media_type"]').val(Publication.gidMediaType);
    $('select[name="publicationType"]').val(Publication.gidPublicationType);
    $('select[name="tier_type"]').val(Publication.gidTier);
    $('select[name="publication_language"]').val(Publication.Language);
    $('select[name="publicationType"]').val(Publication.gidPublicationType);
    $('input[name="master_head"]').val(Publication.Masthead);
    $('input[name="Priority"]').val(Publication.Priority);
    $('input[name="Short_name"]').val(Publication.ShortName);
    
    // Show the modal
    $('#publicationInfo').modal('show');
  }

  function addPublication() {
    $('#modal-title').text('Add Publication');
    $('#publicationForm').attr('action', '{{ route('publication.store') }}');
    $('#publicationForm').trigger('reset');
    $('#publicationInfo').modal('show');
  }
</script>
</div>

@include('common\footer')