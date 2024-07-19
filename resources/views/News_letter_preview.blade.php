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
                <div class="col-md-12 ">
                        <div class="border-with-text" data-heading="Filter Options">
                            <div class="row">
                            <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Process Date From</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="px-1 font-weight-bold" for="media_type">Selection</label>
                                    <select class="form-control" name="" id="">
                                    <option value="">Select</option>
                                    <option value="">Team Wise</option>
                              
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Order </label>
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">Megabytes</option>
                                        <option value="s2">Passionbytes</option>
                                        <option value="s3">Starbytes</option>
                                    </select>
                                </div>
                            
                                <div class="col-md-2 mt-4 pt-2">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <hr>
            <div class="row mt-2">
                <div class="col-md-12 ">
                    <div class="border-with-text" data-heading="News Details">
                        <div class="table-container-responsive">
                            <table class="table table-bordered table-hover ">
                                <thead >
                                <tr>
                                    <th>Company Name</th>
                                    <th>News Send Detail</th>
                                    <th>Today Pending News</th>
                                    <th>Today Send News</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td> <h6 >After Market MFCSL</h6> 
                                        <div>
                                        
                                        <span class="border-right px-1" style="font-size:12px;"><a href="">Process </a></span>
                                        <span class="border-right px-2" style="font-size:12px;"><a href="">Preview</a></span>
                                        <span class="border-right px-2" style="font-size:12px;"><a href="">Similar News</a></span>
                                        <span class="px-1" style="font-size:12px;"><a href="">Deleted</a></span>
                                        </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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