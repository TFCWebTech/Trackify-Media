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
                        <div class="border-with-text" data-heading="Hard Copy">
                            <div class="row">
                             <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="media_type">From Date</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="media_type">To Date</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">City Name</label>
                                    <select class="form-control" name="" id="">
                                    <option value="">Select</option>
                                    <option value="Agra">Agra</option>
                                                            <option value="Ahmadnagar">Ahmadnagar</option>
                                                            <option value="Ahmedabad">Ahmedabad</option>
                                                            <option value="Akola">Akola</option>
                                                            <option value="Alibaug">Alibaug</option>
                                                            <option value="Allahabad">Allahabad</option>
                                                            <option value="Ambala">Ambala</option>
                                                            <option value="Amravati">Amravati</option>
                                                            <option value="Amritsar">Amritsar</option>
                                                            <option value="Anand">Anand</option>
                                                            <option value="Assam">Assam</option>
                                                            <option value="Aurangabad">Aurangabad</option>
                                                            <option value="Bangalore">Bangalore</option>
                                                            <option value="Baroda">Baroda</option>
                                                            <option value="Beed">Beed</option>
                                                            <option value="Belgaon">Belgaon</option>
                                                            <option value="Bengaluru">Bengaluru</option>
                                                            <option value="Bharuch">Bharuch</option>
                                                            <option value="Bhatinda">Bhatinda</option>
                                                            <option value="Bhavnagar">Bhavnagar</option>
                                                            <option value="Bhopal">Bhopal</option>
                                                            <option value="Bhubaneshwar">Bhubaneshwar</option>
                                                            <option value="BHUJ">BHUJ</option>
                                                            <option value="Bikaner">Bikaner</option>
                                                            <option value="Calicut">Calicut</option>
                                                            <option value="Chandigarh">Chandigarh</option>
                                                            <option value="Chennai">Chennai</option>
                                                            <option value="Coimbatore">Coimbatore</option>
                                                            <option value="Cualampur ">Cualampur </option>
                                                            <option value="Cuddalore">Cuddalore</option>
                                                            <option value="cuttack">cuttack</option>
                                                            <option value="Dallas">Dallas</option>
                                                            <option value="Daman">Daman</option>
                                                            <option value="Davangere">Davangere</option>
                                                            <option value="Dehradun">Dehradun</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Dhaka">Dhaka</option>
                                                            <option value="Dhanbad">Dhanbad</option>
                                                            <option value="Dharamshala">Dharamshala</option>
                                                            <option value="Dharwad">Dharwad</option>
                                                            <option value="Dhule">Dhule</option>
                                                            <option value="Disa">Disa</option>
                                                            <option value="Dombivili">Dombivili</option>
                                                            <option value="Durgapur">Durgapur</option>
                                                            <option value="Dwarka">Dwarka</option>
                                                            <option value="Europe">Europe</option>
                                                            <option value="Flash">Flash</option>
                                                            <option value="Gandhinagar">Gandhinagar</option>
                                                            <option value="Ghaziabad">Ghaziabad</option>
                                                            <option value="Goa">Goa</option>
                                                            <option value="Golconda">Golconda</option>
                                                            <option value="Gulbarga">Gulbarga</option>
                                                            <option value="Gurgaon">Gurgaon</option>
                                                            <option value="Guwahati">Guwahati</option>
                                                            <option value="Gwalior">Gwalior</option>
                                                            <option value="Hansalpur">Hansalpur</option>
                                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                            <option value="Himmatnagar">Himmatnagar</option>
                                                            <option value="Hissar">Hissar</option>
                                                            <option value="Hongkong">Hongkong</option>
                                                            <option value="Hoshirpur">Hoshirpur</option>
                                                            <option value="Hubli">Hubli</option>
                                                            <option value="Hyderabad">Hyderabad</option>
                                                            <option value="Imphal">Imphal</option>
                                                            <option value="Indore">Indore</option>
                                                            <option value="International">International</option>
                                                            <option value="Internet">Internet</option>
                                                            <option value="Jabalpur">Jabalpur</option>
                                                            <option value="Jaipur">Jaipur</option>
                                                            <option value="Jalandhar">Jalandhar</option>
                                                            <option value="Jalgoan">Jalgoan</option>
                                                            <option value="Jammu">Jammu</option>
                                                            <option value="Jamnagar">Jamnagar</option>
                                                            <option value="Jamshedpur">Jamshedpur</option>
                                                            <option value="Jharkhand">Jharkhand</option>
                                                            <option value="Jodhpur">Jodhpur</option>
                                                            <option value="Junagadh">Junagadh</option>
                                                            <option value="Kalyan">Kalyan</option>
                                                            <option value="Kanpur">Kanpur</option>
                                                            <option value="Karachi">Karachi</option>
                                                            <option value="Karjat">Karjat</option>
                                                            <option value="Kerala">Kerala</option>
                                                            <option value="Khandala">Khandala</option>
                                                            <option value="Kochi">Kochi</option>
                                                            <option value="Kolhapur">Kolhapur</option>
                                                            <option value="Kolkata">Kolkata</option>
                                                            <option value="Korukupet">Korukupet</option>
                                                            <option value="Kota">Kota</option>
                                                            <option value="Kottayam">Kottayam</option>
                                                            <option value="Kurnool">Kurnool</option>
                                                            <option value="Kutch">Kutch</option>
                                                            <option value="Latur">Latur</option>
                                                            <option value="London">London</option>
                                                            <option value="Lucknow">Lucknow</option>
                                                            <option value="Ludhiana">Ludhiana</option>
                                                            <option value="Madurai">Madurai</option>
                                                            <option value="Malappuram">Malappuram</option>
                                                            <option value="Mangalore">Mangalore</option>
                                                            <option value="Manipur">Manipur</option>
                                                            <option value="Meerut">Meerut</option>
                                                            <option value="Mehdipatnam">Mehdipatnam</option>
                                                            <option value="Mehsana">Mehsana</option>
                                                            <option value="Metro Vartha">Metro Vartha</option>
                                                            <option value="Muktsar">Muktsar</option>
                                                            <option value="Mumbai">Mumbai</option>
                                                            <option value="Mysore">Mysore</option>
                                                            <option value="Nagerkovil">Nagerkovil</option>
                                                            <option value="Nagpur">Nagpur</option>
                                                            <option value="Nanded">Nanded</option>
                                                            <option value="Nashik">Nashik</option>
                                                            <option value="National">National</option>
                                                            <option value="Navi Mumbai">Navi Mumbai</option>
                                                            <option value="Navsari">Navsari</option>
                                                            <option value="New York">New York</option>
                                                            <option value="Noida">Noida</option>
                                                            <option value="orissa">orissa</option>
                                                            <option value="Palakkad">Palakkad</option>
                                                            <option value="Panaji">Panaji</option>
                                                            <option value="Panipat">Panipat</option>
                                                            <option value="Panvel">Panvel</option>
                                                            <option value="Paris">Paris</option>
                                                            <option value="Patna">Patna</option>
                                                            <option value="Pondicherry">Pondicherry</option>
                                                            <option value="Puducherry">Puducherry</option>
                                                            <option value="Pune">Pune</option>
                                                            <option value="Raigad">Raigad</option>
                                                            <option value="Raipur">Raipur</option>
                                                            <option value="Rajkot">Rajkot</option>
                                                            <option value="Rameswaram ">Rameswaram </option>
                                                            <option value="Ranchi">Ranchi</option>
                                                            <option value="Rangareddy">Rangareddy</option>
                                                            <option value="Ratlam">Ratlam</option>
                                                            <option value="Ratnagiri">Ratnagiri</option>
                                                            <option value="Rohtak">Rohtak</option>
                                                            <option value="Roorkee">Roorkee</option>
                                                            <option value="Rourkela">Rourkela</option>
                                                            <option value="salem">salem</option>
                                                            <option value="Sanand">Sanand</option>
                                                            <option value="Sangli">Sangli</option>
                                                            <option value="Satara">Satara</option>
                                                            <option value="Shillong">Shillong</option>
                                                            <option value="Shilsar">Shilsar</option>
                                                            <option value="Shimla">Shimla</option>
                                                            <option value="Shriganganagar">Shriganganagar</option>
                                                            <option value="silchar">silchar</option>
                                                            <option value="Siliguri">Siliguri</option>
                                                            <option value="Sindhudurg">Sindhudurg</option>
                                                            <option value="Singapore">Singapore</option>
                                                            <option value="Solapur">Solapur</option>
                                                            <option value="Sonipat">Sonipat</option>
                                                            <option value="Srinagar">Srinagar</option>
                                                            <option value="Surat">Surat</option>
                                                            <option value="T">T</option>
                                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                                            <option value="Thane">Thane</option>
                                                            <option value="Thiruvananthapuram">Thiruvananthapuram</option>
                                                            <option value="Thiruvanthapurtam">Thiruvanthapurtam</option>
                                                            <option value="Thiruvarur">Thiruvarur</option>
                                                            <option value="Tiruchirappalli">Tiruchirappalli</option>
                                                            <option value="Tirunelveli">Tirunelveli</option>
                                                            <option value="Tirupathi">Tirupathi</option>
                                                            <option value="Trichi">Trichi</option>
                                                            <option value="Trivandrum">Trivandrum</option>
                                                            <option value="Tumkur">Tumkur</option>
                                                            <option value="TV News">TV News</option>
                                                            <option value="Udaipur">Udaipur</option>
                                                            <option value="Ulhasnagar">Ulhasnagar</option>
                                                            <option value="Usmanabad">Usmanabad</option>
                                                            <option value="Vadodara">Vadodara</option>
                                                            <option value="Vapi">Vapi</option>
                                                            <option value="Varanasi">Varanasi</option>
                                                            <option value="Vashi">Vashi</option>
                                                            <option value="Vellore">Vellore</option>
                                                            <option value="Vijaywada">Vijaywada</option>
                                                            <option value="Visakhapatnam">Visakhapatnam</option>
                                                            <option value="Warangal">Warangal</option>
                                                            <option value="Washington">Washington</option>
                                                            <option value="Yavatmal">Yavatmal</option>
                              
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Client </label>
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
                                    <th>Sr. No.</th>
                                    <th>HeadLine Name</th>
                                    <th>Company Name</th>
                                    <th>Publication</th>
                                    <th>Edition</th>
                                    <th>Page No.</th>
                                    <th>Publish Date</th>
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

    </div>
</div>
<script>
    $('table').DataTable();
</script>
</div>

            <!-- End of Main Content -->
@include('common\footer')