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
    label {
    margin-bottom: 0rem !important;
    margin-top: 0rem !important;
}
</style>
<div class="container">
       <div class="card p-3">
            <div class="row">
                <div class="col-md-12 ">
                        <div class="border-with-text" data-heading="Market Watch">
                            <div class="row ">
                                <div class="col-md-2 text-right">
                                    <label class="px-1 font-weight-bold" for="media_type">SENSEX</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>

                                <div class="col-md-2 text-right">
                                    <label class="px-1 font-weight-bold" for="media_type">NIFTY</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>

                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">DOLLAR</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>


                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">EURO</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>


                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">GOLD</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3 ">
                                   <input type="text" class="form-control">
                                </div>

                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">OIL</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>


                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">POUND</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">CONCOR</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>

                                <div class="col-md-2 text-right mt-2">
                                    <label class="px-1 font-weight-bold" for="media_type">TCIL</label>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="" id="">
                                        <option value="">Select</option>
                                        <option value="s1">UP</option>
                                        <option value="s2">DOWN</option>
                                        <option value="s3">NA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                   <input type="text" class="form-control">
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-primary">Search</button>
                                </div>
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