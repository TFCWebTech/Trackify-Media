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
       <div class="card p-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="border-with-text" data-heading="Product Purchases">
                        <form action="/action_page.php">
                        <div class="d-flex justify-content-between">
                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                            <label for="vehicle1"> Archives</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                        <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
                        <label for="vehicle2"> Analysis</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                        <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
                        <label for="vehicle3"> SOV</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="checkbox" id="Reports" name="vehicle3" value="Reports">
                            <label for="Reports"> Reports</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="checkbox" id="EMailService" name="EMailService" value="EMailService">
                            <label for="EMailService"> EMailService</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="checkbox" id="Website_Updation" name="Website_Updation" value="Website_Updation">
                            <label for="Website_Updation"> Website Updation</label><br>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="checkbox" id="NewsletterService" name="NewsletterService" value="NewsletterService">
                            <label for="NewsletterService">Newsletter Service</label><br>
                        </div>
                            <input type="submit" class="btn btn-primary mt-1" value="Submit">
                        </form>
                    </div>
                </div>
                <div class="col-md-8 ">
                    <div class="border-with-text" data-heading="Product Purchases by This Client">
                        <div class="table-container-responsive">
                            <table class="table table-bordered table-hover ">
                                <thead >
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Archives</td>
                                    <td> <i class="fa fa-trash" style="color:red;"></i> </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Analysis</td>
                                    <td> <i class="fa fa-trash" style="color:red;"></i> </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>SOV</td>
                                    <td> <i class="fa fa-trash" style="color:red;"></i> </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Reports</td>
                                    <td> <i class="fa fa-trash" style="color:red;"></i> </td>
                                </tr>
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
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')