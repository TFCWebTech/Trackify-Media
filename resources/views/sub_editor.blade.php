@include('common/header')


<div class="container">
    <div class="text-right p-1">
        <button class="btn btn-primary" id="toggleButton">Show/Hide Headline Search</button>
    </div>

    <div class="card p-3 my-2"  id="headlineSearchSection" style="display: none;">
        <div class="row">
        <div class="col-md-12 ">
                <div class="border-with-text" data-heading="Filter Options">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="px-1 font-weight-bold" for="media_type">Headline</label>
                            <input type="text" class="form-control" placeholder="Enter Headline">
                        </div>
                        <div class="col-md-3">
                            <label class="px-1 font-weight-bold" for="media_type">From Date</label>
                            <input type="date" class="form-control" placeholder="Enter From Date">
                        </div>
                        <div class="col-md-3">
                            <label class="px-1 font-weight-bold" for="media_type">To Date</label>
                            <input type="date" class="form-control" placeholder="Enter To Date">
                        </div>
                        <div class="col-md-2 mt-4 pt-1">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
   
    <div class="card p-3">
        <div class="row">
            <div class="col-md-12">
                        <div class="text-center">
                            <h5 class="font-weight-bold text-uppercase text-color">Reporter Upload</h5>
                        </div>
            </div>

            <div class="col-md-12" >
                        <div class="border-with-text" data-heading="Sub Editor Upload">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Media Type </label>
                                            <select class="form-control" name="" id="">
                                                <option value="">Select</option>
                                                <option value="">Magazine</option>
                                                <option value="">NewsPaper</option>
                                                <option value="">Online</option>
                                                <option value="">RSS</option>
                                                <option value="">TV</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Status</label>
                                            <select class="form-control" name="" id="">
                                                <option value="">Select</option>
                                                <option value="">Pending</option>
                                                <option value="">Finalised</option>
                                                <option value="">Delete</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Start Letter </label>
                                            <input type="text" placeholder="Start Letter" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">By </label>
                                            <select class="form-control" name="" id="">
                                                <option value="">Select</option>
                                                <option value="">Category</option>
                                                <option value="">Sector</option>
                                                <option value="">Client</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="media_type">Category </label>
                                            <select class="form-control" name="" id="">
                                                <option value="">Select</option>
                                                <!-- <option value="">Category</option>
                                                <option value="">Sector</option>
                                                <option value="">Client</option> -->
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="px-1 font-weight-bold" for="media_type">News </label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="px-1 font-weight-bold" for="media_type">Article Information </label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="px-1 font-weight-bold" for="media_type">Category Information</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="px-1 font-weight-bold" for="media_type">Category Information</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                        </div>
            </div>
        </div>

    </div>
</div>

<!-- this div is for footer --->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            // Toggle button click event
            $('#toggleButton').click(function() {
                // Toggle visibility of the section
                $('#headlineSearchSection').toggle();
            });
        });
</script>
@include('common/footer')