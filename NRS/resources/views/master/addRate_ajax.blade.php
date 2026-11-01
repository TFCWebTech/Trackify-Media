<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

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
</div>

<script>
       $('#table').DataTable();
</script>