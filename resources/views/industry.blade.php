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
<div class="container">
        <div class="row">
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Edition</button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12" >
                <div class="table-container-responsive">
                <table class="table table-bordered table-hover ">
                <thead >
                <tr>
                    <th>Industry Name</th>
                    <th>Company Name</th>
                    <th>KeyWords</th>
                    <th>Status</th>
                   
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Car</td>
                    <td>TATA Moter</td>
                    <td>electric car</td>
                    <td>Active</td>
                    
                    <!-- <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td> -->
                </tr>
                <tr>
                <td>Car</td>
                    <td>TATA Moter</td>
                    <td>electric car</td>
                    <td>Active</td>
                  
                    <!-- <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td> -->
                </tr>
               


                </tbody>
            
            </table>
            </div>
        </div>
</div></div>

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
            <form action="/action_page.php">
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Edition Name </label>
                    <input type="text" class="form-control" placeholder="Enter Edition Name" name="publiction_name" required>
                </div>
           
              
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Edition Order </label>
                    <input type="text" class="form-control" placeholder="Enter Edition Order" name="publiction_name" required>
                </div>
                <div class="form-group">
                <label class="px-1 font-weight-bold" for="tier_type">Publication  </label>
                  <select class="form-control" name="" id="">
                    <option value="">Select</option>
              
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
</div>

            <!-- End of Main Content -->
@include('common\footer')