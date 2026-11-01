@include('common/header')


<div class="container" >
    <div class="card p-3">
    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        <form action="{{route('add_artical')}}" method="post"> 
            @csrf
            <div class="row">
                    <div class="col-md-12 py-2">
                        <div class="text-center">
                            <h5 class="font-weight-bold text-uppercase text-color">Reporter Upload</h5>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12" >
                        <div class="border-with-text" data-heading="Media Information">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Media Type: Test</label>
                                            <select class="form-control" name="media_type" >
                                                <option value="">Select</option>
                                                <option value="Magazine">Magazine</option>
                                                <option value="NewsPaper">NewsPaper</option>
                                                <option value="Online">Online</option>
                                                <option value="RSS">RSS</option>
                                                <option value="TV">TV</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Publication</label>
                                            <select class="form-control" name="publication" >
                                                <option value="">Select</option>
                                                <option value="4Ps">4Ps</option>
                                                <option value="50 Fashion Brand Icons">50 Fashion Brand Icons</option>
                                                <option value="Aag">Aag</option>
                                                <option value="Abraxas Lifestyle Magazine">Abraxas Lifestyle Magazine</option>
                                                <option value="Acaai News">Acaai News</option>
                                                <option value="Accommodation Times">Accommodation Times</option>
                                                <option value="ACE">ACE</option>
                                               
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Edition</label>
                                            <select class="form-control" name="edition" >
                                                <option value="">Select</option>
                                                <option value="National">National</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Supplement</label>
                                            <select  class="form-control"  name="SupplementId" id="SupplementId1" accesskey="s">
                                            <option value="1">Select</option>
                                            <option value="bf59dde41ba391ab8a79958743e31742b1bbe144">  </option>
                                            <option value="ae06c283bf57559341e3ae3446b25ea93517c979"> A Celebration Of Life </option>
                                            <option value="9b3c9ca46debe5adfa631eef2591d88765dabf15"> Aadab Hyderabad </option>
                                            <option value="7671b50f6b5450fd5976d9f46c0a8c90ba30b03a"> ahmedabad </option>
                                            <option value="82a9be3ae1ebe39f2513c568f4f26ca4d209b6dc"> Alappuzha </option>
                                            <option value="d4b08de76ef09ce3caf6d1d894e2c588ec90d28a"> Amritsar </option>
                                            <option value="e46297efaff2b296760d5f2e4f458d1e6fbf9bbc"> Anantha </option>
                                            <option value="f85812cfbd0c0ab6c771b1b192a833a0fce95e21"> Asset Allocation </option>
                                            <option value="c6bcb345d41e1bfd75eda38de8ef052e6f8578c2"> auto drive  </option>
                                            <option value="dc2db2122bec191076b0e7c08ea7f7654d3ed7bd"> AUTOCAR SPORT </option>
                                            <option value="1b6049ac9b32c6d74245a97931c4148927f42b6a"> Automotive Retail </option>
                                            <option value="53a023c8c579c6cb274a4d745e616f89d6ea289a"> AVENUES </option>
                                            <option value="b7a49604f8e1ae99fd6ce44b390333cd799f70af"> Baja Saeindia </option>
                                            <option value="fb373d3e1bbf08a89f70dea77cd5985a2a2e954f"> bangaloreplus </option>
                                            <option value="8dca55cc518511b7e9d1e7203c2309bb380ae064"> Bankers Trust </option>
                                            <option value="e667de999a64ed27e0f4d1452a1893c1a0ad5e22"> Banking annual </option>
                                            <option value="6d0467fc419c8784f199fba9ef018a9f45eb2836"> Banking Technology </option>
                                            <option value="c4dd3aa7d12fe6df4e11d5efdd1b98c7d5580b8f"> Banking Technology Award 2015 </option>
                                            <option value="217bb2d2d6f9ddd531c9ca9cb48d2272797e5c37"> BENGAL Towards Economic Resurgence  </option>
                                            <option value="e2510c95612adf7cbfb715bedcaecf725afbae85"> Bhubaneswar </option>
                                            <option value="f7fbf8c9937385299ce0987075ed51de941ec19d"> Big Bike Guide </option>
                                            <option value="9afcf5acd1e605ebeca6c77da1a72f05b6c7ea01"> bizjournal.com </option>
                                            <option value="37d0ab324fe24a77082dc234abf538813d3f6b03"> Blink </option>
                                            <option value="017b336264da3fb6cfd48e1e16357de33ccbbb0b"> Brands in the ascendance  </option>
                                            <option value="31a8438b7f4ba9726050b61256d779ef4a5fe4a1"> BS1000 Annual </option>
                                            <option value="82612f42a4decb4e917051df72c9f3bf8954ddeb"> Business Day </option>
                                            <option value="82c39c82ba3c48fc9710529feff0fe03b3b277d0"> Celebrating a second life </option>
                                            <option value="e0c634c81cf755d611f6d9ec04dd682f05aaebd9"> Chandigarh Spokesman </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Publication Date</label>
                                            <input type="date" class="form-control" name="publication_date" id="publication_date">
                                        </div>
                                    </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" >
                        <div class="border-with-text" data-heading="Journalist Information">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" name="journalist_name" for="journalist_name">Journalist Name:</label>
                                            <select class="form-control" name="journalist_name" id="">
                                                <option value="0">Select</option>
                                                <option value="Magazine">Magazine</option>
                                                <option value="NewsPaper">NewsPaper</option>
                                                <option value="Online">Online</option>
                                                <option value="RSS">RSS</option>
                                                <option value="TV">TV</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="px-1 font-weight-bold" for="journalist_email">Journalist Email:</label>
                                            <input type="email" class="form-control" placeholder="Enter Journalist Email"  name="journalist_email">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="author">Author</label>
                                            <input type="text" class="form-control" placeholder="Enter Author" name="author">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Page No</label>
                                            <input type="number" class="form-control" placeholder="Enter Page No" name="page_no">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="width">width </label>
                                            <input type="text" class="form-control" placeholder="Enter width " name="width">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="Height">Height </label>
                                            <input type="text" class="form-control" placeholder="Enter Height " name="Height">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Agency :</label>
                                            <select name="AgencyId" class="form-control" id="AgencyId1" onchange="hideJList()" accesskey="a">
                                            <option value="1">Select</option>
                                            <option value="Agencies">Agencies</option>
                                            <option value="Bloomberg">Bloomberg</option>
                                            <option value="Bureau">Bureau</option>
                                            <option value="Correspondent">Correspondent</option>
                                            <option value="PTI">PTI</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">News Position :</label>
                                            <select name="NewsPositionId"  class="form-control" accesskey="n" id="NewsPositionId1" onkeyup="validateUserType('?text=' + this.value);">
                                            <option value="1">Select</option>
                                            <option value="Bottom">Bottom</option>
                                            <option value="Bottom Center">Bottom Center</option>
                                            <option value="Bottom Left">Bottom Left</option>
                                            <option value="Bottom Right">Bottom Right</option>
                                            <option value="Fullpage">Full page</option>
                                            <option value="Half Page">Half Page</option>
                                            <option value="Internet">Internet</option>
                                            <option value="Middle">Middle</option>
                                            <option value="Middle Center">Middle Center</option>
                                            <option value="Middle Left">Middle Left</option>
                                            <option value="Quarter Page">Quarter Page</option>
                                            <option value="Top">Top</option>
                                            <option value="Top Center">Top Center</option>
                                            <option value="Top Left">Top Left</option>
                                            <option value="Top Right">Top Right</option>
                                            <option value="TV">TV</option>
                                            </select>
                                        </div>
                                    
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">News City:</label>
                                            <select name="NewsCityID"  class="form-control" accesskey="n" id="NewsPositionId1" onkeyup="validateUserType('?text=' + this.value);">
                                            <option value="1">Select</option>
                                                <option value="Assam">Assam</option>
                                                    <option value="Usmanabad">Usmanabad</option>
                                                    <option value="Thiruvarur">Thiruvarur</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="2A51">Tiruchirappalli</option>
                                                    <option value="Dombivili">Dombivili</option>
                                                    <option value="Nagerkovil">Nagerkovil</option>
                                                    <option value="Jalandhar">Jalandhar</option>
                                                    <option value="Himmatnagar">Himmatnagar</option>
                                                    <option value="Tumkur">Tumkur</option>
                                                    <option value="Panvel">Panvel</option>
                                                    <option value="orissa">orissa</option>
                                                    <option value="Dhanbad">Dhanbad</option>
                                                    <option value="Udaipur">Udaipur</option>
                                                    <option value="Visakhapatnam">Visakhapatnam</option>
                                                   
                                                </select>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="px-1 font-weight-bold" for="media_type">Category :</label>
                                            <select name="category"  class="form-control" accesskey="n" onkeyup="validateUserType('?text=' + this.value);">
                                            <option value="0">Select</option>
                                            <option value="111" >111</option>
                                            <option value="After Market MFCSL" >After Market MFCSL</option>
                                            <option value="After Market MFCWL" >After Market MFCWL</option>
                                            <option value="Agri Andreas Stihl" >Agri Andreas Stihl</option>
                                            <option value="Agri Honda Siel Power Products" >Agri Honda Siel Power Products</option>
                                            <option value="Agri KisanKraft" >Agri KisanKraft</option>
                                            <option value="Agriculture INDUSTRY" >Agriculture INDUSTRY</option>
                                            <option value="Airline Air France" >Airline Air France</option>
                                            <option value="Airline Air India" >Airline Air India</option>
                                            <option value="Airline AirAsia" >Airline AirAsia</option>
                                            <option value="Airline Airbus" >Airline Airbus</option>
                                            <option value="Airline Airport Infrastructure" >Airline Airport Infrastructure</option>
                                            <option value="Airline Bengaluru International Airport" >Airline Bengaluru International Airport</option>
                                            <option value="Airline BIAL Transport" >Airline BIAL Transport</option>
                                            <option value="Airline Boeing" >Airline Boeing</option>
                                          
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Time">Time</label>
                                            <input type="text" class="form-control" name="current_time" id="current_time" placeholder="Enter Time">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Duration">Duration</label>
                                            <input type="text" class="form-control" placeholder="Enter Duration" name="Duration">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="px-1 font-weight-bold" for="HeadLine">HeadLine</label>
                                            <textarea id="w3review" class="form-control" name="headline" rows="4" cols="50">
                                            
                                            </textarea>
                                        </div>  
                                        <div class="col-md-6">
                                            <label class="px-1 font-weight-bold" for="media_type">Summary</label>
                                            <textarea id="w3review" class="form-control" name="Summary" rows="4" cols="50">
                                            </textarea>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3" >
                        <div class="border-with-text" data-heading="Article Editing">
                            <div class="row">
                                <div class="col-md-4 p-2">
                                    <label class=" font-weight-bold" for="Height">Height </label>
                                    <input type="file" class="form-control"  placeholder="Enter Height " name="1">
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4 p-2">
                                    <label class=" font-weight-bold" for="Height">Upload Orignal Image Test </label>
                                    <input type="file" class="form-control"  placeholder="Enter Height " name="12">
                                </div>
                                <div class="col-md-4 p-2">
                                    <label class=" font-weight-bold" for="Height">Upload HTML </label>
                                    <input type="file" class="form-control"  placeholder="Enter Height " name="12">
                                </div>
                                <div class="col-md-12">
                                <textarea style="padding:30%;" name="editor1" class="form-control" placeholder="Write Something..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-6 px-4 py-2">
                    <button  class="btn btn-success">Preview</button>
                    <button  class="btn btn-secondary">Output</button>
                </div>
                <div class="col-md-6 text-right px-4 py-2">
                    <button  class="btn btn-success">Additional Page</button>
                    <button type="submit" class="btn btn-primary">Save Page</button>
                </div>
            </div>
        </form>

    </div>
</div>          
<script>
        // Get the current time
        const currentTime = new Date();
        
        // Format the current time as HH:MM:SS
        const formattedTime = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        // Set the formatted time in the input field
        document.getElementById("current_time").value = formattedTime;
    </script>
<!-- this div is for footer --->
</div>

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
 <script type="text/javascript">
   CKEDITOR.replace( 'editor1' );
</script>

@include('common/footer')