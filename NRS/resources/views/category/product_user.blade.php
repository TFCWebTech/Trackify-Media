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
<div class="text-right p-1">
        <button class="btn btn-primary" id="toggleButton">Add Product User</button>
    </div>

<div class="card p-3 my-2"  id="headlineSearchSection" style="display: none;">
        <div class="row px-3">
            <div class="col-md-12 ">
                <div class="border-with-text" data-heading="New User">
                    <div class="row">
                        <div class="col-md-6 p-4 border-right">
                        <label class="px-1 font-weight-bold" for="media_type">User Name</label>
                                    <input type="date" class="form-control">
                            <br>
                             <label class="px-1 font-weight-bold" for="media_type">Email Address:</label>
                                    <input type="email" class="form-control">
                        </div>
                        <div class="col-md-6 p-4">
                    <div class="d-flex justify-content-between m-2">
                            
                            <label for="vehicle1"> Admin User</label> 
                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                       
                        <label for="vehicle2"> Web User</label>
                        <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                        
                        <label for="vehicle3"> NewsLetterService</label>
                        <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                    <label for="Reports"> Send Updates</label>

                            <input type="checkbox" id="Reports" name="vehicle3" value="Reports">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                    <label for="EMailService"> Analysis</label>

                            <input type="checkbox" id="EMailService" name="EMailService" value="EMailService">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                            <label for="Website_Updation"> Archives</label>
                            <input type="checkbox" id="Website_Updation" name="Website_Updation" value="Website_Updation">

                    </div>
                    <div class="d-flex justify-content-between m-2">
                    <label for="NewsletterService">EMail Service </label>
                            <input type="checkbox" id="NewsletterService" name="NewsletterService" value="NewsletterService">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                    <label for="NewsletterService">Reports  </label>
                            <input type="checkbox" id="NewsletterService" name="NewsletterService" value="NewsletterService">
                    </div>
                    <div class="d-flex justify-content-between m-2">
                    <label for="NewsletterService">SOV  </label>
                            <input type="checkbox" id="NewsletterService" name="NewsletterService" value="NewsletterService">
                    </div>
                    </div>
                        <div class="col-md-12 pt-1 text-right">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       <div class="card p-3">
        
            <div class="row mt-2">
                <div class="col-md-12 ">
                    <div class="border-with-text" data-heading="News Details">
                        <div class="table-container-responsive">
                            <table class="table table-bordered table-hover ">
                                <thead >
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Services</th>
                                    <th>Main User</th>
                                    <th>Send Updates</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                        
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>
<script>
    $('table').DataTable();

    $(document).ready(function() {
            // Toggle button click event
            $('#toggleButton').click(function() {
                // Toggle visibility of the section
                $('#headlineSearchSection').toggle();
            });
        });
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')