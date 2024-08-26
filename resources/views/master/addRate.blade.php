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
label {
    margin-bottom: 0rem !important;
    margin-top: 0rem !important;
}
/* @media (min-width: 768px) { */
        .table-container-responsive{
            overflow-x: auto;
        }
    /* } */

        /* Simple CSS for loader */
        #loader {
            display: none;
            position: fixed;
            left: 50%;
            top: 40%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
            z-index: 11111;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn {
    margin-top: 8px;
    font-size: .8rem !important;
    height: 33px;
}
</style>
<div class="container" >
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
        <div class="row pb-2">
          <div class="col-md-12 d-flex ">  
            <h1 class="p-2 mr-auto h5 mb-0 text-gray-800 ">Manage Add Rate</h1>
            <div class="p-2 search-box d-flex">
              <label class="pt-1 font-weight-bold" for="user_type">MediaType</label> &nbsp;
              <select class="form-control" name="media_types" id="media_types" onchange="findMedia(this.value)" >
                  <option value="All">All</option>
                  @foreach($media_type as $media)
                      <option value="{{ $media->gidMediaType }}">{{ $media->MediaType }}</option>
                  @endforeach
              </select>&nbsp;
            </div>&nbsp;
            <button class="btn btn-primary" onclick="addAddRate()">New Rate</button>
          </div>
        </div>
        <div id="loader"></div>
        <div class="row" id="getMediaData">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table id="table" class="table table-bordered table-hover ">
                <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Publication Name</th>
                    <th>Edition</th>
                    <th>Supplement</th>
                    <th>Rate</th>
                    <th>New Rate</th>
                    <th>Circulation Figure</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                         $i = 0; ?>
                @foreach($addrate as $add_rate_data)
                <?php $i++; 
                           ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$add_rate_data -> publication}}</td>
                    <td>{{$add_rate_data -> edition}}</td>
                    <td>{{$add_rate_data -> supplement}}</td>
                    <td>{{$add_rate_data -> Rate}}</td>
                    <td>{{$add_rate_data -> NewRate}}</td>
                    <td>{{$add_rate_data -> Circulation_Fig}}</td>
                    <td>  
                      @if($add_rate_data ->Status == 1)
                          Inactive
                      @else
                          Active
                      @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($add_rate_data->CreatedOn)->format('d/m/Y') }}</td>  
                    <td>
                     <i class="fa fa-edit text-primary" onclick="editAddRate({{ json_encode($add_rate_data) }})"></i>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div></div>


<!-- The Modal -->
<div class="modal fade" id="addRateInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title">Add Journalist</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="addRateForm" action="{{ route('addRate.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label class="px-1 font-weight-bold" for="media_type">Media Type</label>
            <select class="form-control" name="media_type" id="mediaTypeSelect" onchange="changeMedia(this.value)"> 
              <option value="">Select</option>
              @foreach($media_type as $media)
                <option value="{{ $media->gidMediaType }}">{{ $media->MediaType }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="publication">Publication</label>
            <select class="form-control" name="publication" id="publicationSelect" onchange="changePublication(this.value)"> 
              <option value="">Select</option>
            </select>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="edition">Edition</label>
            <select class="form-control" name="edition" id="editionSelect" onchange="changeEdition(this.value)">
              <option value="">Select</option>
            </select>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="supplement">Supplement</label>
            <select class="form-control" name="supplement" id="supplementSelect">
            <option value="">Select</option>
            </select>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="rate">Rate</label>
            <input type="text" class="form-control" placeholder="Enter Rate" name="rate" required>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="new_rate">New Rate</label>
            <input type="text" class="form-control" placeholder="Enter New Rate" name="new_rate" required>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="number_of_circulation">Number of Circulation</label>
            <input type="text" class="form-control" placeholder="Enter Number of Circulation" name="number_of_circulation" required>
          </div>

          <div class="form-group">
            <label class="px-1 font-weight-bold" for="status">Status</label>
            <select class="form-control" name="status">
              <option value="">Select</option>
              <option value="0">Active</option>
              <option value="1">Inactive</option>
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
 function editAddRate(add_rate_data) {
  $('#modal-title').text('Update Add Rate');
  $('#addRateForm').attr('action', `/NRS/AddRate/update/${add_rate_data.gidAddRate_id}`);
  
  // Set media type
  $('select[name="media_type"]').val(add_rate_data.gidMediaType);

  // Set publication options and value
  changeMedia(add_rate_data.gidMediaType).then(() => {
    $('select[name="publication"]').val(add_rate_data.gidMediaOutlet);

    // Set edition options and value
    changePublication(add_rate_data.gidMediaOutlet).then(() => {
      $('select[name="edition"]').val(add_rate_data.gidEdition);

      // Set supplement options and value
      changeEdition(add_rate_data.gidEdition).then(() => {
        $('select[name="supplement"]').val(add_rate_data.gidSupplement);

        // Set other input values
        $('input[name="rate"]').val(add_rate_data.Rate);
        $('input[name="new_rate"]').val(add_rate_data.NewRate);
        $('input[name="number_of_circulation"]').val(add_rate_data.Circulation_Fig);
        $('select[name="status"]').val(add_rate_data.Status);

        // Show the modal
        $('#addRateInfo').modal('show');
      }).catch((error) => {
        console.error('Error setting supplement:', error);
      });
    }).catch((error) => {
      console.error('Error setting edition:', error);
    });
  }).catch((error) => {
    console.error('Error setting publication:', error);
  });
}

function changeMedia(media) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getPublication') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        media: media
      },
      success: function(response) {
        $('#publicationSelect').html(response.options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}

function changePublication(publication) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getEdition') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        publication: publication
      },
      success: function(response) {
        $('#editionSelect').html(response.options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}

function changeEdition(edition) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getSupplement') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        edition: edition
      },
      success: function(response) {
        $('#supplementSelect').html(response.options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}

function addAddRate() {
  $('#modal-title').text('Add Add Rate');
  $('#addRateForm').attr('action', '{{ route('addRate.store') }}');
  $('#addRateForm').trigger('reset');
  $('#addRateInfo').modal('show');
}
</script>

<script>
    // AJAX function to fetch data
    function findMedia(media_type) {
            console.log(media_type);

            if (media_type === '') {
                alert('Please select a media type');
                return;
            }

            // Show loader
            document.getElementById('loader').style.display = 'block';

            $.ajax({
                url: '{{ route('getDataByMedia') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    media_types: media_type
                },
                success: function(data) {
                    $('#getMediaData').html(data);

                    // Hide loader
                    document.getElementById('loader').style.display = 'none';
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);

                    // Hide loader
                    document.getElementById('loader').style.display = 'none';
                }
            });
        }
    
    $('#table').DataTable();
</script>

</div>
@include('common/footer')
            <!-- End of Main Content -->