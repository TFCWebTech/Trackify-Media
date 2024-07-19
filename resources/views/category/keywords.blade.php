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
.heading-color{
    color:#224abecc !important;
}
/* @media (min-width: 768px) { */
        .table-container-responsive{
            overflow-x: auto;
        }
    /* } */
</style>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
<div class="container">
    <div class="card p-3">
        <form action="" id="mainForm">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="heading-color"><u><b class="pb-2"> Category Name:-111 </b></u></h6>
                </div>

                <div class="col-md-12">
                    <div class="border-with-text" id="formContainer" data-heading="Add Keywords">

                        <div class="row dynamic-form">
                            <div class="col-md-12 mb-2">
                                <label class="px-1 font-weight-bold" for="media_type">Keywords</label>
                                <textarea name="keywords[]" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-md-6 border-right">
                                <label class="px-1 font-weight-bold" for="media_type">Media</label> <br>
                                <input type="checkbox" class="ml-1" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="vehicle1" class="m-1"> Newspaper </label>
                                <input type="checkbox" class="ml-1" id="vehicle2" name="vehicle2" value="Car">
                                <label for="vehicle2" class="m-1"> Online </label>
                                <input type="checkbox" class="ml-1" id="vehicle3" name="vehicle3" value="Boat">
                                <label for="vehicle3" class="m-1"> Magazine </label>
                                <input type="checkbox" class="ml-1" id="vehicle3" name="vehicle3" value="Boat">
                                <label for="vehicle3" class="m-1"> TV </label>
                            </div>
                            <div class="col-md-6">
                                <label class="px-1 font-weight-bold" for="media_type">Relevance</label> <br>
                                <input type="radio" class="ml-1" id="None" name="Relevance" value="None">
                                <label for="None" class="m-1"> None </label>
                                <input type="radio" class="ml-1" id="100" name="Relevance" value="100">
                                <label for="100" class="m-1"> 100 </label>
                                <input type="radio" class="ml-1" id="50" name="Relevance" value="50">
                                <label for="50" class="m-1"> 50 </label>
                                <input type="radio" class="ml-1" id="25" name="Relevance" value="25">
                                <label for="25" class="m-1"> 25 </label>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>

                    </div>
                    <style>
                        .removeForm {
                            display: none;
                        }
                    </style>
                    <div class="col-md-12 text-right mt-4 pt-2">
                        <button type="button" class="btn btn-danger removeBtn">Delete</button>
                        <button type="button" class="btn btn-success addMoreBtn">Add More</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="border-with-text" data-heading="Main Keywords">
                <div class="table-container-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Keywords</th>
                                <th>Relevance</th>
                                <th>Created Under</th>
                                <th>Edit / Delete</th>
                                <th>Created By / Created On</th>
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
<script>
    $('table').DataTable();
    document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("formContainer");
    const addMoreBtn = document.querySelector(".addMoreBtn");

    addMoreBtn.addEventListener("click", function () {
        const dynamicForm = document.createElement("div");
        dynamicForm.classList.add("row", "dynamic-form");

        dynamicForm.innerHTML = `
            <div class="col-md-12 mb-2">
                <label class="px-1 font-weight-bold" for="media_type">Keywords</label>
                <textarea name="keywords[]" class="form-control" id="" cols="30" rows="5"></textarea>
            </div>
            <div class="col-md-6 border-right">
                <label class="px-1 font-weight-bold" for="media_type">Media</label> <br>
                <input type="checkbox" class="ml-1" id="vehicle1" name="vehicle1" value="Bike">
                <label for="vehicle1" class="m-1"> Newspaper </label>
                <input type="checkbox" class="ml-1" id="vehicle2" name="vehicle2" value="Car">
                <label for="vehicle2" class="m-1"> Online </label>
                <input type="checkbox" class="ml-1" id="vehicle3" name="vehicle3" value="Boat">
                <label for="vehicle3" class="m-1"> Magazine </label>
                <input type="checkbox" class="ml-1" id="vehicle3" name="vehicle3" value="Boat">
                <label for="vehicle3" class="m-1"> TV </label>
            </div>
            <div class="col-md-6">
                <label class="px-1 font-weight-bold" for="media_type">Relevance</label> <br>
                <input type="radio" class="ml-1" id="None" name="Relevance" value="None">
                <label for="None" class="m-1"> None </label>
                <input type="radio" class="ml-1" id="100" name="Relevance" value="100">
                <label for="100" class="m-1"> 100 </label>
                <input type="radio" class="ml-1" id="50" name="Relevance" value="50">
                <label for="50" class="m-1"> 50 </label>
                <input type="radio" class="ml-1" id="25" name="Relevance" value="25">
                <label for="25" class="m-1"> 25 </label>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        `;

        formContainer.appendChild(dynamicForm);
        updateDeleteButtons();
    });

    function updateDeleteButtons() {
        const deleteBtns = document.querySelectorAll(".removeBtn");
        deleteBtns.forEach(btn => {
            btn.addEventListener("click", function () {
                const parentForm = this.closest(".dynamic-form");
                parentForm.remove();
            });
        });
    }

    updateDeleteButtons();

    // Prevent form submission
    const mainForm = document.getElementById("mainForm");
    mainForm.addEventListener("submit", function (event) {
        event.preventDefault();
    });
});
</script>
</div>


            <!-- End of Main Content -->
@include('common\footer')