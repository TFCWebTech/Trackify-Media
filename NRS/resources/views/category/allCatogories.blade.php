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
    .hidden {
    display: none;
  }
</style>
<div class="container">
        <div class="row">
            <div class="col-md-12 text-right p-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Category </button>
            </div>
        </div>
     
        <div class="row mt-2">
            <div class="col-md-12 card p-3" >
                <div class=" table-container-responsive">
                <table class="table table-bordered table-hover ">
                <thead >
                <tr>
                    <th>Category Name</th>
                    <th>Sector </th>
                    <th>Client Type</th>
                    <th>Version </th>
                    <th>Teams</th>
                    <th>Expire Date</th>    
                    <th>Sub ditor</th>
                    <th>Status</th>
                    <th>Create At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td> <h6 class="text-center">111 (1111)</h6> 
                    <div> 
                    <span class="border-right px-2" style="font-size:12px;"><a href="{{route('add_keywords')}}">Keywords</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href="">ProPR Template</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href="">Linked</a></span>
                    <br>    
                    <span class="border-right px-2" style="font-size:12px;"><a href="">SubEditData</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href=""> Comment</a></span>
                    </div>
                    </td>
                    <td>Auto</td>
                    <td>Category</td>
                    <td>ProPR</td>
                    <td>Megabytes</td>
                    <td>21/04/2025</td>
                    <td>Yes</td>
                    <td>Active</td>
                   
                    <td>21/04/2011</td>
                    <td>
                    &nbsp; <i class="fa fa-edit text-primary"></i> &nbsp; 
                        <i class="fa fa-trash text-danger" ></i>
                    </td>
                </tr>
                <tr>
                    <td> <h6 class="text-center">After Market MFCSL</h6> 
                    <div>
                    
                    <span class="border-right px-2" style="font-size:12px;"><a href="{{route('product_purches_service')}}">Services</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href="{{route('add_keywords')}}">Keywords</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href="">ProPR Template</a></span>
                   
                    <br>    
                    <span class="border-right px-2" style="font-size:12px;"><a data-toggle="modal" data-target="#addLogo">Logo</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a href="{{route('product_users')}}">Users</a></span> 
                    <span class="border-right px-2" style="font-size:12px;"><a href="{{route('competition')}}">SOV</a></span>
                    <span class="border-right px-2" style="font-size:12px;"><a data-toggle="modal" data-target="#showLinked">Linked</a></span>
                    <br>
                    <span class="border-right px-2" style="font-size:12px;"><a href=""> SubEditData</a></span>
                    </div>
                    </td>
                    <td>Auto</td>
                    <td>Category</td>
                    <td>ProPR</td>
                    <td>Megabytes</td>
                    <td>21/04/2025</td>
                    <td>Yes</td>
                    <td>Active</td>
                   
                    <td>21/04/2011</td>
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
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="/action_page.php">
            <div class="row">
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Category Name  </label>
                        <input type="text" class="form-control" placeholder="Enter Category Name" name="publiction_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Display Name  </label>
                        <input type="text" class="form-control" placeholder="Enter Display Name" name="publiction_name" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Nick Name  </label>
                        <input type="text" class="form-control" placeholder="Enter Nick Name" name="publiction_name" required>
                    </div>
                </div>
           
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Sector   </label>
                        <select class="form-control" name="" id="">
                        <option value="">Select</option>
                        <option value="">Magazine</option>
                        <option value="">NewsPaper</option>
                        <option value="">Online</option>
                        <option value="">RSS</option>
                        <option value="">TV</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Show in RP/SE  </label>
                        <select class="form-control" name="" id="">
                        <option value="">Select</option>
                        <option value="">Yes</option>
                        <option value="">No</option>
                        </select>
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Client  </label>
                        <select class="form-control" name="" id="client_select">
                        <option value="">Select</option>
                            <option value="1">Client</option>
                            <option value="0" selected="">Category</option>
                            <option value="2">Group</option>
                            <option value="3">SOV</option>
                            <option value="4">QSOV</option>
                        </select>
                    </div>
                </div> 
                </div> 
                <div class="row" id="hiddenContent">
                    <div class="col-md-6" >
                        <div class="form-group" >
                            <label class="px-1 font-weight-bold" for="tier_type">Expiry Date  </label>
                            <input type="text" class="form-control" placeholder="Enter Expiry Date" name="publiction_name" required>
                        </div>
                    </div>
           
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Version  </label>
                            <select class="form-control" name="" id="">
                            <option value="1">ProPR</option>
                            <option value="2">NewsTrac</option>                            
                            <option value="3">Taj-Mahal</option>	
                            <option value="4">Mini Rooster</option>
                            <option value="5">TV</option>						
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Website URL</label>
                            <input type="text" class="form-control" placeholder="Enter Website URL" name="publiction_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Send Blank Mail  </label>
                            <select class="form-control" name="" id="">
                            <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="3">No</option>
                                <option value="4">QSOV</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>  
                <div class="row">  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Teams  </label>
                            <select class="form-control" name="" id="">
                            <option value="0">Select</option>	
                            <option value="1">Megabytes</option>
                            <option value="2">Passionbytes</option>                            
                            <option value="3">Starbytes</option>					
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">NewTV  </label>
                            <select class="form-control" name="" id="">
                            <option value="0">Select</option>	
                            <option value="1">Yes</option>
                            <option value="2">No</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Show Highlight Keywords  </label>
                            <select class="form-control" name="" id="">
                            <option value="0">Select</option>	
                            <option value="1">Yes</option>
                            <option value="2">No</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">BBQualify Status </label>
                            <select class="form-control" name="" id="">
                            <option value="0">Select</option>	
                            <option value="1">Yes</option>
                            <option value="2">No</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Auto WebUpdate </label>
                            <select class="form-control" name="" id="">
                            <option value="0">Select</option>	
                            <option value="1">Yes</option>
                            <option value="2">No</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Highlight Summary Option </label>
                            <select class="form-control" name="" id="">
                            <option value="1">Default Summary</option>
                            <option value="2">Summary with Highlight</option>
                            <option value="3">Summary without Highlight</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="px-1 font-weight-bold" for="tier_type">Comment</label>
                            <textarea  class="form-control" name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 text-right pt-2">   
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
<!-- The Modal -->
<div class="modal" id="addLogo">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Logo</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="/action_page.php">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="px-1 font-weight-bold" for="tier_type">Logo </label>
                        <input type="file" class="form-control"  name="publiction_name" required>
                    </div>
              
                    <div class="col-md-12 text-right pt-2">   
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!-- The Modal -->
<div class="modal" id="showLinked">
  <div class="modal-dialog ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Linked</h4>
        <!-- Correct close button for Bootstrap 4 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
            <form action="/action_page.php">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="Mahindra After Market" disabled>
                    </div>
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="After Market MFCSL" disabled>
                    </div>
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="Sales Mahindra" disabled>
                    </div>
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="Mahindra Aftermarket Sector" disabled>
                    </div>
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="Test Client M3" disabled>
                    </div>
                    <div class="form-group m-1">
                        <input type="text" class="form-control" value="APP Auto" disabled>
                    </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    $('table').DataTable();

    document.addEventListener("DOMContentLoaded", function() {
    var clientSelect = document.getElementById("client_select");
    var hiddenContent = document.getElementById("hiddenContent");

    // Initially hide the content
    hiddenContent.classList.add("hidden");

    // Add event listener for select change
    clientSelect.addEventListener("change", function() {
        if (clientSelect.value === "0") { // Category selected
            hiddenContent.classList.add("hidden");
        } else { // Any other option selected
            hiddenContent.classList.remove("hidden");
        }
    });
});
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')