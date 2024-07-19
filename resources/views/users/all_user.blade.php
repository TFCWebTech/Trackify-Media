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
</style>
<div class="container">
        <div class="row">
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add User</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-hover dt-responsive">
                <thead >
                <tr>
                    <th>User Name</th>
                    <th>User Id</th>
                    <th>IP Address</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Aarti</td>
                    <td>Pune Aarti</td>
                    <td>103.231.3.202</td>
                    <td>Admin</td>
                    <td>Active</td>
                    <td>26/05/2012</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>karumbu</td>
                    <td>Chennai Karumbu</td>
                    <td>103.231.3.202</td>
                    <td>Admin</td>
                    <td>Active</td>
                    <td>26/05/2012</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Abhishek</td>
                    <td>Abhishek Kolkata</td>
                    <td>115.187.39.9</td>
                    <td>Reporter</td>
                    <td>Active</td>
                    <td>26/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Ajay</td>
                    <td>Pune Ajay</td>
                    <td>103.90.162.159</td>
                    <td>SubEditor</td>
                    <td>Active</td>
                    <td>03/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>

                <tr>
                    <td>Kalyani</td>
                    <td>Kalyani</td>
                    <td>123.201.36.101	</td>
                    <td>Admin</td>
                    <td>Active</td>
                    <td>26/05/2012</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Jitendra</td>
                    <td>Kolkata Jitendra</td>
                    <td>115.187.39.60</td>
                    <td>Reporter</td>
                    <td>Active</td>
                    <td>26/05/2012</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Abhishek</td>
                    <td>Abhishek Kolkata</td>
                    <td>115.187.39.9</td>
                    <td>Reporter</td>
                    <td>Active</td>
                    <td>26/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Ajay</td>
                    <td>Pune Ajay</td>
                    <td>103.90.162.159</td>
                    <td>SubEditor</td>
                    <td>Active</td>
                    <td>03/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>gitesh</td>
                    <td>mumbai gitesh</td>
                    <td>125.99.90.74</td>
                    <td>SubEditor</td>
                    <td>Active</td>
                    <td>26/05/2017</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Gurvinder Delhi</td>
                    <td>Gurvinder Delhi</td>
                    <td>150.242.173.255</td>
                    <td>Reporter</td>
                    <td>Active</td>
                    <td>26/05/2012</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Harish</td>
                    <td>Hyderabad Harish</td>
                    <td>103.231.3.202</td>
                    <td>Reporter</td>
                    <td>Active</td>
                    <td>26/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td>Harishj</td>
                    <td>Harishj Pune </td>
                    <td>103.231.3.202</td>
                    <td>Admin</td>
                    <td>Active</td>
                    <td>03/07/2018</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>

                </tbody>
            
            </table>
            </div>
        </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New User</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="/action_page.php">
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">User Name </label>
                    <input type="text" class="form-control" placeholder="Enter User Name" name="user_type" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">User Id </label>
                    <input type="text" class="form-control" placeholder="Enter User Id" name="user_type" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Password </label>
                    <input type="password" class="form-control" placeholder="Enter User Id" name="user_type" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Re-Type Password </label>
                    <input type="password" class="form-control" placeholder="Enter User Id" name="user_type" required>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">User Type </label>
                    <select name="" id="" class="form-control">
                        <option value="">Admin</option>
                        <option value="">SubEditor</option>
                        <option value="">Reporter</option>
                        <option value="">NewsAnalyzer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="px-1 font-weight-bold" for="user_type">Sector </label>
                    <select name="" id="" class="form-control">
                    <option value="" >Agriculture</option>
                    <option value="">Auto</option>
                    <option value="">Aviation</option>
                    <option value="">Biotech</option>
                    <option value="">Chemical</option>
                    <option value="">Commodity</option>
                    <option value="">Consulate</option>
                    <option value="">Consumer Durable</option>
                    <option value="">Corporate</option>
                    <option value="">Education</option>
                    <option value="">Energy</option>
                    <option value="">Engineering</option>
                    <option value="">Entertainment</option>
                    <option value="">Excellence</option>
                    <option value="">Finance</option>
                    <option value="">FMCG</option>
                    <option value="">Health &amp; Wellness</option>
                    <option value="">Healthcare</option>
                    <option value="">Hospitality</option>
                    <option value="">HR</option>
                    <option value="">Infrastructure</option>
                    <option value="">IT</option>
                    <option value="">Liquor</option>
                    <option value="">Logistic</option>
                    <option value="">MEL</option>
                    <option value="">Miscellaneous</option>
                    <option value="">NGO</option>
                    <option value="">Nutrition</option>
                    <option value="">Political</option>
                    <option value="">Rating</option>
                    <option value="">Real Estate</option>
                    <option value="">Retail</option>
                    <option value="">Security</option>
                    <option value="">Sports</option>
                    <option value="">Telecom</option>
                    <option value="">Transportation</option>
                    <option value="">Travel</option>
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