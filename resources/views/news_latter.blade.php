@include('common\header')

<!-- Include the necessary CSS and JS libraries for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<div class="card p-4">
<form action="<?php //echo base_url('NewsLetter/sendMailToMultipleClient');?>" method="post">

    <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" class="btn text-primary font-weight-bold"> Process </button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>News Send Detail</th>
                <th>Today Pending News</th>
                <th>Today Send News</th>
                <!-- <th><input type="checkbox" id="checkAll" value="checkAll"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php //foreach($get_clients as $clients): ?>
                <tr>
                    <td>TATA Moters <i class="fa fa-eye text-primary "></i></a> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td><input type="checkbox" class="checkBox" name="client_id[]" value="<?php //echo $clients['client_id'];?>"></td> -->
                </tr>
            <?php //endforeach; ?>
        </tbody>
    </table>
</form>

</div>

</div>
<script>
    document.getElementById("checkAll").addEventListener("click", function() {
        var checkBoxes = document.getElementsByClassName("checkBox");
        for (var i = 0; i < checkBoxes.length; i++) {
            checkBoxes[i].checked = this.checked;
        }
    });
</script>