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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container">
       <div class="card p-3">
            <div class="row">
                <div class="col-md-12 ">
                        <div class="border-with-text" data-heading="After Market MFCWL">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="px-1 font-weight-bold" for="media_type">Category</label>
                                    <select  class="js-example-basic-multiple form-control"  name="doctor_name[]" multiple required>
                                    <option value="1">Select</option>
                                    <option value="2">Team Wise1</option>
                                    <option value="3">Team Wise2</option>
                                    <option value="4">Team Wise3</option>
                                    <option value="5">Team Wise4</option>
                                    <option value="6">Team Wise5</option>
                                    <option value="7">Team Wise6</option>
                                    <option value="8">Team Wise6</option>
                                    <option value="9">Team Wise7</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4 pt-2">
                                    <button class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <hr>
            <div class="row mt-2">
                <div class="col-md-12 ">
                    <div class="border-with-text" data-heading="">
                        <div class="table-container-responsive">
                            <table class="table table-bordered table-hover ">
                                <thead >
                                <tr>
                                    <th>Client Name</th>
                                    <th>Competition Name</th>
                                    <th>	Status</th>
                                    <th>Created At</th>
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
    $('.js-example-basic-multiple').select2();
});
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')