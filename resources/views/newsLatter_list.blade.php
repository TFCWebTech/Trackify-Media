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
.cursor{
    cursor: pointer;
}

</style>
<div class="card p-4">

    <!-- <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" class="btn text-primary font-weight-bold"> Process </button>
        </div>
    </div> -->
    <table class="table table-bordered table-hover dt-responsive">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Company Name</th>
                <th>News Send Detail</th>
                <th>Today Pending News</th>
                <th>Today Send News</th>
                <!-- <th><input type="checkbox" id="checkAll" value="checkAll"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
                @foreach($Company as $values)
                <?php $i ++ ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{ $values -> client_name}} <a href="{{ route('newsLatter', ['client_id' => $values->client_id]) }}"><i class="fa fa-eye text-primary cursor"></i></a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td><input type="checkbox" class="checkBox" name="client_id[]" value="<?php //echo $clients['client_id'];?>"></td> -->
                </tr>
            @endforeach
        </tbody>
            
    </table>

</div>

</div>
<script>
 
    $('table').DataTable();
</script>