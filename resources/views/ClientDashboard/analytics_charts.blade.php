@include('common/clientDashboard-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<style>

body {
        width: 100;
    }
    .chart-container {
        display: none !important;
        height: 400px;
    }
    .chart-container.active {
        display: block !important;
        height: 400px;
    }
    .chart-container-2 {
        display: none !important;
        height: 400px;
    }
    .chart-container-2.active {
        display: block !important;
        height: 400px;
    }
    .chart-container-3 {
        display: none !important;
        height: 400px;
    }
    .chart-container-3.active {
        display: block !important;
        height: 400px;
    }
    .chart-container-4 {
        display: none !important;
        height: 400px;
    }
    .chart-container-4.active {
        display: block !important;
        height: 400px;
    }
    .chart-container-5 {
        display: none !important;
        height: 400px;
    }
    .chart-container-5.active {
        display: block !important;
        height: 400px;
    }
    .chart-container-6 {
        display: none !important;
        height: 400px;
    }
    .chart-container-6.active {
        display: block !important;
        height: 400px;
    }
    label {
    font-size: 0.8rem !important;
    margin-top: 0.5rem !important;
}
</style>
<div class="container">

<div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-12 d-flex justify-content-between ">
                            <div class="div d-flex">
                                <form id="clientForm" class="d-flex" style="height:35px;">
                                    <label class="px-1 font-weight-bold mt-1" for="publication_type">Select Client</label>
                                    <select class="form-control" name="select_client" id="select_client" style="width:200px;">
                                        @foreach($client_list as $clients)
                                            <option value="{{ $clients->client_id }}">{{ $clients->client_name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="d-flex">
                                <form method="post" action="">
                                    <div class="d-flex ">
                                        <label for="from-date"> From: </label> &nbsp;
                                        <input id="from-date" name="from" class="form-control" type="date"  required> &nbsp;
                                        <label for="to-date"> To: </label> &nbsp;
                                        <input id="to-date" name="to" class="form-control" type="date"  required>
                                        &nbsp;<button type="button" onclick="getDataByDate()" class="bg-primary border-primary text-light"> <i class="fa fa-search "></i></button> 
                                    </div>
                                </form> &nbsp;&nbsp;
                                <!-- <input type="text" name="daterange" value="01/01/2015 - 01/31/2015" /> -->
                                <div class="mb-4">
                                    <select name="" id="chartTypeSelector" class="form-control" onchange="handleChartTypeChange()">
                                            <option value="Quantity">Quantity</option>
                                            <option value="Size">Size</option>
                                            <option value="Media">Media</option>
                                            <option value="Publication">Publication</option>
                                            <option value="Geography">Geography</option>
                                            <option value="Journalist">Journalist</option>
                                        
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="quantity">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart('monthly')">Monthly</button>

                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Quantity</h6>
                    </div>
                </div>
                <div id="areaChart" class="chart-container">
                    <canvas id="myAreaChart"></canvas>
                </div>
                <div id="pieChart" class="chart-container">
                    <canvas id="myqPieChart"></canvas>
                </div>
                <div id="barChart" class="chart-container">
                    <canvas id="myBarChart"></canvas>
                </div>
                <div id="lineChart" class="chart-container">
                    <canvas id="myLineChart"></canvas>
                </div>
                <div id="verticalBarChart" class="chart-container">
                    <canvas id="myVerticalBarChart"></canvas>
                </div>
               
                <div id="quantityShowTable" class="chart-container" style="display: none;">
                    <table id="quantityTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid gray;">Date</th>
                                <th style="border: 1px solid gray;">News Count</th>
                                <th style="border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <!-- <button class="btn btn-primary" onclick="showChart('areaChart')">Area Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart('pieChart')">Doughnut Chart</button>
                    <button class="btn btn-primary" onclick="showChart('barChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart('lineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart('verticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart('quantityShowTable')">Show Table</button>

                </div>
            </div>

            <div class="size">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart2('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart2('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart2('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Size</h6>
                    </div>
                </div>
                <div id="sizeareaChart" class="chart-container-2">
                    <canvas id="sizeAreaChart"></canvas>
                </div>
                <div id="sizepieChart" class="chart-container-2">
                    <canvas id="sizePieChart"></canvas>
                </div>
                <div id="sizebarChart" class="chart-container-2">
                    <canvas id="sizeBarChart"></canvas>
                </div>
                <div id="sizelineChart" class="chart-container-2">
                    <canvas id="sizeLineChart"></canvas>
                </div>
                <div id="sizeverticalBarChart" class="chart-container-2">
                    <canvas id="sizeVerticalBarChart"></canvas>
                </div>
                <div id="sizeShowTable" class="chart-container-2" style="display: none;">
                    <table id="sizeTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr id="sizeTableHeader">
                                <!-- Dynamic header will be inserted here -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <button class="btn btn-primary" onclick="showChart2('sizepieChart')">Stacked Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizebarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizelineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizeverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizeShowTable')">Show Table</button>
                </div>
            </div>
            <div class="media">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart3('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart3('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart3('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Media</h6>
                    </div>
                </div>
                <div id="mediaareaChart" class="chart-container-3">
                    <canvas id="MediaAreaChart"></canvas>
                </div>
                <div id="mediapieChart" class="chart-container-3">
                    <canvas id="mediaPieChart"></canvas>
                </div>
                <div id="mediabarChart" class="chart-container-3">
                    <canvas id="mediaBarChart"></canvas>
                </div>
                <div id="medialineChart" class="chart-container-3">
                    <canvas id="mediaLineChart"></canvas>
                </div>
                <div id="mediaverticalBarChart" class="chart-container-3">
                    <canvas id="mediaVerticalBarChart"></canvas>
                </div>
                <div id="mediaShowTable" class="chart-container-3" style="display: none;">
                    <table id="mediaTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid gray;">Media Type</th>
                                <!-- Month headers will be populated dynamically -->
                                <!-- Example: <th style="border: 1px solid gray;">June</th> -->
                                <!-- Example: <th style="border: 1px solid gray;">July</th> -->
                                <th style="border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <!-- <button class="btn btn-primary" onclick="showChart3('mediaareaChart')">Area Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart3('mediapieChart')">Stacked  Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('mediabarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('medialineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('mediaverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('mediaShowTable')">Show Table</button>
                </div>
            </div>

            <div class="publication">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart4('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart4('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart4('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6 class="text-primary">Overview / Publication</h6>
                        </div>
                    </div>
                    <div id="publicationareaChart" class="chart-container-4">
                        <canvas id="publicationAreaChart"></canvas>
                    </div>
                    <div id="publicationpieChart" class="chart-container-4">
                        <canvas id="publicationPieChart"></canvas>
                    </div>
                    <div id="publicationbarChart" class="chart-container-4">
                        <canvas id="publicationBarChart"></canvas>
                    </div>
                    <div id="publicationlineChart" class="chart-container-4">
                        <canvas id="publicationLineChart"></canvas>
                    </div>
                    <div id="publicationverticalBarChart" class="chart-container-4">
                        <canvas id="publicationVerticalBarChart"></canvas>
                    </div>
                    <div id="publicationShowTable" class="chart-container-4" style="display: none;">
                    <table id="publicationTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid gray;">Publication</th>
                                <!-- Month headers will be populated dynamically -->
                                <!-- Example: <th style="border: 1px solid gray;">June</th> -->
                                <!-- Example: <th style="border: 1px solid gray;">July</th> -->
                                <th style="border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                    <div class="my-4">
                        <!-- <button class="btn btn-primary" onclick="showChart4('publicationareaChart')">Area Chart</button> -->
                        <button class="btn btn-primary" onclick="showChart4('publicationpieChart')">Stacked Chart</button>
                        <button class="btn btn-primary" onclick="showChart4('publicationbarChart')">Bar Chart</button>
                        <button class="btn btn-primary" onclick="showChart4('publicationlineChart')">Line Chart</button>
                        <button class="btn btn-primary" onclick="showChart4('publicationverticalBarChart')">Column Chart</button>
                        <button class="btn btn-primary" onclick="showChart4('publicationShowTable')">Show Table</button>
                    </div>
            </div>

            <div class="geography">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart5('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart5('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart5('monthly')">Monthly</button>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Geography</h6>
                    </div>
                </div>
                <div id="geographyareaChart" class="chart-container-5">
                    <canvas id="geographyAreaChart"></canvas>
                </div>
                <div id="geographypieChart" class="chart-container-5">
                    <canvas id="geographyPieChart"></canvas>
                </div>
                <div id="geographybarChart" class="chart-container-5">
                    <canvas id="geographyBarChart"></canvas>
                </div>
                <div id="geographylineChart" class="chart-container-5">
                    <canvas id="geographyLineChart"></canvas>
                </div>
                <div id="geographyverticalBarChart" class="chart-container-5">
                    <canvas id="geographyVerticalBarChart"></canvas>
                </div>
                <!-- <div id="geographytableChart" class="chart-container-5">
                    <canvas id="geographyTableChart"></canvas>
                </div> -->
                <div id="geographyShowTable" class="chart-container-5" style="display: none;">
                    <table id="geographyTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid gray;">Geography</th>
                                <!-- Month headers will be populated dynamically -->
                                <!-- Example: <th style="border: 1px solid gray;">June</th> -->
                                <!-- Example: <th style="border: 1px solid gray;">July</th> -->
                                <th style="border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <!-- <button class="btn btn-primary" onclick="showChart5('geographyareaChart')">Area Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart5('geographypieChart')">Stacked Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographybarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographylineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographyverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographyShowTable')">Show Table</button>
                </div>
            </div>
            <div class="journalist">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <button class="btn btn-secondary" onclick="updateChart6('daily')">Daily</button>
                            <button class="btn btn-secondary" onclick="updateChart6('weekly')">Weekly</button>
                            <button class="btn btn-secondary" onclick="updateChart6('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Journalist</h6>
                    </div>
                </div>
                <div id="journalistareaChart" class="chart-container-6">
                    <canvas id="journalistAreaChart"></canvas>
                </div>
                <div id="journalistpieChart" class="chart-container-6">
                    <canvas id="journalistPieChart"></canvas>
                </div>
                <div id="journalistbarChart" class="chart-container-6">
                    <canvas id="journalistBarChart"></canvas>
                </div>
                <div id="journalistlineChart" class="chart-container-6">
                    <canvas id="journalistLineChart"></canvas>
                </div>
                <div id="journalistverticalBarChart" class="chart-container-6">
                    <canvas id="journalistVerticalBarChart"></canvas>
                </div>
                <div id="journalistShowTable" class="chart-container-6" style="display: none;">
                    <table id="journalistTable" style="width:100%; border: 1px solid gray;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid gray;">Journalist</th>
                                <th style="border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <button class="btn btn-primary" onclick="showChart6('journalistpieChart')">Stacked Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistbarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistlineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistShowTable')">Show Table</button>
                </div>
            </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // function getDataByDate(){
        
    //     var select_client = document.getElementById('select_client').value;
    //     var from_date = document.getElementById('from-date').value;
    //     var to_date = document.getElementById('to-date').value;
    //     console.log(select_client);
    //     console.log(from_date);
    //     $.ajax({
    //         url: '{{ route('fetchAnalyticsData') }}',
    //         method: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             select_client: select_client,
    //             from_date: from_date,
    //             to_date: to_date
    //         },
    //         success: function(response) {
    //             console.log(response);
    //         }

    //     });
    // }
</script>
<script>
// $('#select_client').change(function()
    function getDataByDate(){
        var select_client = document.getElementById('select_client').value;
        var from_date = document.getElementById('from-date').value;
        var to_date = document.getElementById('to-date').value;
        console.log(select_client);
        console.log(from_date);
        // const clientId = $(this).val();

        // Store date range globally
        globalFromDate = from_date;
        globalToDate = to_date;

        $.ajax({
            url: '{{ route('fetchAnalyticsData') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                select_client: select_client,
                from_date: from_date,
                to_date: to_date
            },
            success: function(response) {
                console.log(response);

                // Assuming response contains quantity_graph_daily, quantity_graph_weekly, and quantity_graph_monthly
                quantityData = {
                    daily: response.quantity_graph_daily,
                    weekly: response.quantity_graph_weekly,
                    monthly: response.quantity_graph_monthly
                };

                mediaData = {
                    daily: response.media_graph_daily,
                    weekly: response.media_graph_weekly,
                    monthly: response.media_graph_monthly
                };

                publicationData = {
                    daily: response.publication_graph_daily,
                    weekly: response.publication_graph_weekly,
                    monthly: response.publication_graph_monthly
                };

                geographyData = {
                    daily: response.geography_graph_daily,
                    weekly: response.geography_graph_weekly,
                    monthly: response.geography_graph_monthly
                };

                journalistData = {
                    daily: response.Journalist_graph_daily,
                    weekly: response.Journalist_graph_weekly,
                    monthly: response.Journalist_graph_monthly
                };

                sizeData = {
                    daily: response.size_daily_data,
                    weekly: response.size_weekly_data,
                    monthly: response.size_monthly_data
                };

                // Update charts and table with daily data as default
                updateChart('daily');
                showChart('lineChart'); // Show the line chart by default
                updateChart3('daily');
                showChart3('medialineChart'); // Show the line chart by default
                updateChart4('daily');
                showChart4('publicationlineChart'); // Show the line chart by default
                updateChart5('daily');
                showChart5('geographylineChart'); // Show the line chart by default
                updateChart6('daily'); // This selects the daily data as the default
                showChart6('journalistlineChart'); // This shows the line chart by default
                updateChart2('daily'); // This selects the daily data as the default
                showChart2('sizelineChart'); // This shows the line chart by default
            },

            error: function(xhr) {  
                console.error('Error fetching data:', xhr.responseText);
            }
        });
    };

    let quantityData = {
        daily: [],    // Initially empty, will be populated after AJAX success
        weekly: [],
        monthly: []
    };

    // Chart contexts
    const areaChartCtx = document.getElementById('myAreaChart').getContext('2d');
    const pieChartCtx = document.getElementById('myqPieChart').getContext('2d');
    const barChartCtx = document.getElementById('myBarChart').getContext('2d');
    const lineChartCtx = document.getElementById('myLineChart').getContext('2d');
    const verticalBarChartCtx = document.getElementById('myVerticalBarChart').getContext('2d');

    // Initialize Chart.js charts
    let areaChart = new Chart(areaChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });
    let pieChart = new Chart(pieChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['Direct', 'Social', 'Referral'],
            datasets: [{
                data: [],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    let barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                },
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });
    let lineChart = new Chart(lineChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });
    let verticalBarChart = new Chart(verticalBarChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    // Function to show the selected chart and populate quantity table
   function showChart(chartId) {
    const charts = document.querySelectorAll('.chart-container');
    charts.forEach(chart => chart.classList.remove('active'));
    document.getElementById(chartId).classList.add('active');
    
    if (chartId === 'quantityShowTable') {
        // Default to daily, but this will be updated when timeframe buttons are clicked
        populateQuantityTable(quantityData.daily || [], 'daily');
    }
}

function populateQuantityTable(data, timeFrame = 'daily') {
    const tableBody = document.querySelector("#quantityTable tbody");
    tableBody.innerHTML = ""; 

    let totalNewsCount = 0;
    let totalSumAve = 0; // Sum of weighted averages
    let totalCount = 0;  // Total count across all rows

    // Sort data by date for better display
    const sortedData = [...data].sort((a, b) => {
        if (timeFrame === 'monthly') {
            // Parse month names for sorting
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                               'July', 'August', 'September', 'October', 'November', 'December'];
            const aMonth = monthNames.indexOf(a.label.split(' ')[0]);
            const aYear = parseInt(a.label.split(' ')[1]);
            const bMonth = monthNames.indexOf(b.label.split(' ')[0]);
            const bYear = parseInt(b.label.split(' ')[1]);
            
            if (aYear !== bYear) return aYear - bYear;
            return aMonth - bMonth;
        } else if (timeFrame === 'weekly') {
            // Sort by year and week number
            const aYear = a.year || new Date(a.start_date).getFullYear();
            const bYear = b.year || new Date(b.start_date).getFullYear();
            const aWeek = a.weekNumber || 0;
            const bWeek = b.weekNumber || 0;
            
            if (aYear !== bYear) return aYear - bYear;
            return aWeek - bWeek;
        }
        // For daily, sort by date
        const aDate = a.start_date || a.label;
        const bDate = b.start_date || b.label;
        return new Date(aDate) - new Date(bDate);
    });

    sortedData.forEach(item => {
        let row = document.createElement("tr");

        let labelCell = document.createElement("td");
        // For weekly data, show the date range if available
        let displayLabel = formatDateLabel(item.label, timeFrame);
        if (timeFrame === 'weekly' && item.dateRange) {
            displayLabel = item.dateRange;
        }
        labelCell.textContent = displayLabel || "N/A";
        labelCell.style.border = "1px solid gray"; 
        row.appendChild(labelCell);

        let countCell = document.createElement("td");
        let countValue = item.count ? parseInt(item.count) : 0;
        countCell.textContent = countValue.toLocaleString('en-US');
        countCell.style.border = "1px solid gray"; 
        row.appendChild(countCell);

        let aveCell = document.createElement("td");
        let aveValue = item.total_ave ? parseFloat(item.total_ave) : 0;
        aveCell.textContent = aveValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        aveCell.style.border = "1px solid gray"; 
        row.appendChild(aveCell);

        tableBody.appendChild(row);

        // Calculate totals
        totalNewsCount += countValue;
        totalSumAve += aveValue * countValue; // Sum of weighted averages
        totalCount += countValue;
    });

    // Add a summary row for totals
    if (sortedData.length > 0) {
        let totalRow = document.createElement("tr");

        let totalLabelCell = document.createElement("td");
        totalLabelCell.textContent = "Total";
        totalLabelCell.style.fontWeight = "bold";
        totalLabelCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalLabelCell);

        let totalCountCell = document.createElement("td");
        totalCountCell.textContent = totalNewsCount.toLocaleString('en-US');
        totalCountCell.style.fontWeight = "bold";
        totalCountCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalCountCell);

        let totalAveCell = document.createElement("td");
        // Calculate overall average
        let overallAve = totalCount > 0 ? (totalSumAve / totalCount).toFixed(2) : "0.00";
        totalAveCell.textContent = parseFloat(overallAve).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        totalAveCell.style.fontWeight = "bold";
        totalAveCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalAveCell);

        tableBody.appendChild(totalRow);
    }
}
    // Function to format date labels for better readability
    function formatDateLabel(label, timeFrame) {
        if (timeFrame === 'daily') {
            // Check if label is a date string (YYYY-MM-DD format)
            if (/^\d{4}-\d{2}-\d{2}$/.test(label)) {
                const date = new Date(label + 'T00:00:00');
                const day = date.getDate();
                const month = date.toLocaleString('en-US', { month: 'short' });
                const year = date.getFullYear();
                return `${day} ${month} ${year}`;
            }
        }else if (timeFrame === 'weekly') {
        // For weekly data, we want to show a more readable format
        // Check if label is in format "Week-X YYYY"
        const weekMatch = label.match(/Week-(\d+) (\d+)/);
        if (weekMatch) {
            const weekNumber = weekMatch[1];
            const year = weekMatch[2];
            return `Week ${weekNumber}, ${year}`;
        }
        // Alternatively, if we have dateRange property
        if (label.dateRange) {
            return label.dateRange;
        }
        // Or if it's already formatted nicely
        return label;
    } else if (timeFrame === 'monthly') {
        // For monthly, just return as is (should be "Month Year" format)
        return label;
    }
        return label;
    }

    function generateAllWeeks(fromDate, toDate) {
    const weeks = [];
    const start = new Date(fromDate + 'T00:00:00');
    const end = new Date(toDate + 'T00:00:00');
    
    // Start from the beginning of the week (Sunday)
    const current = new Date(start);
    current.setDate(current.getDate() - current.getDay());
    
    // Format as YYYY-MM-DD
    const formatDate = (date) => date.toISOString().split('T')[0];
    
    // Generate all weeks in the range
    while (current <= end) {
        const weekStart = new Date(current);
        const weekEnd = new Date(current);
        weekEnd.setDate(weekEnd.getDate() + 6);
        
        // Get week number and year
        const [weekYear, weekNumber] = getWeekNumber(weekStart);
        
        // Format as "Week-X YYYY"
        const weekLabel = `Week-${weekNumber} ${weekYear}`;
        const dateRange = `${weekStart.toLocaleString('default', { month: 'short', day: 'numeric' })} - ${weekEnd.toLocaleString('default', { month: 'short', day: 'numeric', year: 'numeric' })}`;
        
        weeks.push({
            start: formatDate(weekStart),
            end: formatDate(weekEnd),
            label: weekLabel,
            dateRange: dateRange,
            weekNumber: weekNumber,
            year: weekYear
        });
        
        // Move to next week
        current.setDate(current.getDate() + 7);
    }
    
    return weeks;
}

function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
    return [d.getUTCFullYear(), weekNo];
}

    function fillMissingWeeks(data, fromDate, toDate) {
    if (!fromDate || !toDate) return data || [];
    
    const allWeeks = generateAllWeeks(fromDate, toDate);
    const dataMap = new Map();
    
    // Create a map of existing data by label (week)
    (data || []).forEach(item => {
        dataMap.set(item.label, item);
    });
    
    // Fill in missing weeks with zero values
    const filledData = allWeeks.map(week => {
        const weekLabel = week.label; // Format: "Week-X YYYY"
        
        if (dataMap.has(weekLabel)) {
            return {
                ...dataMap.get(weekLabel),
                start_date: week.start,
                end_date: week.end
            };
        } else {
            // Return zero value object based on the structure of the first item
            if (data && data.length > 0) {
                const sample = data[0];
                const zeroItem = { 
                    label: weekLabel, 
                    count: 0 
                };
                // Copy other properties from sample with zero values
                if (sample.total_ave !== undefined) zeroItem.total_ave = 0;
                if (sample.category !== undefined) zeroItem.category = sample.category;
                if (sample.MediaType !== undefined) zeroItem.MediaType = sample.MediaType;
                if (sample.MediaOutlet !== undefined) zeroItem.MediaOutlet = sample.MediaOutlet;
                if (sample.Edition !== undefined) zeroItem.Edition = sample.Edition;
                if (sample.Journalist !== undefined) zeroItem.Journalist = sample.Journalist;
                zeroItem.start_date = week.start;
                zeroItem.end_date = week.end;
                return zeroItem;
            } else {
                return { 
                    label: weekLabel, 
                    count: 0, 
                    total_ave: 0,
                    start_date: week.start,
                    end_date: week.end
                };
            }
        }
    });
    
    // Sort by year and week number
    return filledData.sort((a, b) => {
        const aYear = a.year || new Date(a.start_date).getFullYear();
        const bYear = b.year || new Date(b.start_date).getFullYear();
        const aWeek = a.weekNumber || 0;
        const bWeek = b.weekNumber || 0;
        
        if (aYear !== bYear) return aYear - bYear;
        return aWeek - bWeek;
    });
}

    // Function to update all charts based on selected time frame
    function updateChart(timeFrame) {
        
        
        let data = [];
        let labels = [];
        let selectedData = quantityData[timeFrame]; 

        // Fill missing months with zero values if monthly
        if (globalFromDate && globalToDate) {
            if (timeFrame === 'monthly') {
                selectedData = fillMissingMonths(selectedData, globalFromDate, globalToDate);
            } else if (timeFrame === 'weekly') {
                selectedData = fillMissingWeeks(selectedData, globalFromDate, globalToDate);
            }
            console.log('updateChart fillMissingData for', timeFrame, selectedData);
        }

        selectedData.forEach(item => {
            labels.push(formatDateLabel(item.label, timeFrame));
            data.push(item.count);
        });

        console.log('updateChart labels', labels);
        console.log('updateChart data', data);
        
        updateChartData(areaChart, labels, data);
        const pieLabels = [];
        const pieData = [];

        labels.forEach((label, index) => {
            if (data[index] > 0) {
                pieLabels.push(label);
                pieData.push(data[index]);
            }
        });
        // updateChartData(pieChart, labels.slice(0, 3), data.slice(0, 3)); 
        if (pieData.length > 0) {
            updateChartData(pieChart, pieLabels, pieData);
        } else {
            pieChart.clear(); // optional
        }

        updateChartData(barChart, labels, data);
        updateChartData(lineChart, labels, data);
        updateChartData(verticalBarChart, labels, data);

        populateQuantityTable(selectedData, timeFrame);
    }

    // Function to update data for a given chart
    function updateChartData(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets.forEach(dataset => {
            dataset.data = data;
        });
        chart.update();
    }

    let sizeData = {
        daily: [],
        weekly: [],
        monthly: []
    };

    // Chart contexts
    const sizeAreaChartCtx = document.getElementById('sizeAreaChart').getContext('2d');
    const sizePieChartCtx = document.getElementById('sizePieChart').getContext('2d');
    const sizeBarChartCtx = document.getElementById('sizeBarChart').getContext('2d');
    const sizeLineChartCtx = document.getElementById('sizeLineChart').getContext('2d');
    const sizeVerticalBarChartCtx = document.getElementById('sizeVerticalBarChart').getContext('2d');

    // Initialize charts
    let sizeAreaChart = new Chart(sizeAreaChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let sizePieChart = new Chart(sizePieChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(78, 115, 223, 0.5)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });

        let sizeBarChart = new Chart(sizeBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let sizeLineChart = new Chart(sizeLineChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let sizeVerticalBarChart = new Chart(sizeVerticalBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

    // Function to update chart data
   
    function updateChartData2(chart, labels, data) {
            chart.data.labels = labels;
            chart.data.datasets.forEach((dataset) => {
                dataset.data = data;
            });
            chart.update();
        }
    // Function to show the selected chart and populate quantity table
    function showChart2(chartId) {
        const charts = document.querySelectorAll('.chart-container-2');
        charts.forEach(chart => chart.classList.remove('active'));
        document.getElementById(chartId).classList.add('active');
        if (chartId === 'sizeShowTable') {
            populateSizeTable(sizeData.daily); 
        }
    }

    // Function to populate the quantity table with data
    function populateSizeTable(data) {
    const tableBody = document.querySelector("#sizeTable tbody");
    const tableHeader = document.querySelector("#sizeTable thead tr");

    // Clear existing headers and rows
    tableHeader.innerHTML = "";
    tableBody.innerHTML = "";

    // First, get all unique time periods (weeks/months) and categories
    const uniqueLabels = [...new Set(data.map(item => item.label))];
    const uniqueCategories = [...new Set(data.map(item => item.category).filter(cat => cat))];
    
    // Sort labels based on time period
    const sortedLabels = uniqueLabels.sort((a, b) => {
        // Try to sort by date if possible
        try {
            const aDate = a.start_date || a;
            const bDate = b.start_date || b;
            return new Date(aDate) - new Date(bDate);
        } catch (e) {
            return a.localeCompare(b);
        }
    });

    // Build header row
    let headerRow = "<th style='border: 1px solid gray;'>Size Category</th>";
    sortedLabels.forEach(label => {
        headerRow += `<th style='border: 1px solid gray;'>${formatDateLabel(label, 'weekly')}</th>`;
    });
    headerRow += "<th style='border: 1px solid gray;'>Total</th>";
    headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
    tableHeader.innerHTML = headerRow;

    // Build rows for each category
    uniqueCategories.forEach(category => {
        let row = document.createElement("tr");
        
        let categoryCell = document.createElement("td");
        categoryCell.textContent = category || "Uncategorized";
        categoryCell.style.border = "1px solid gray";
        row.appendChild(categoryCell);

        let categoryTotal = 0;
        let categoryAve = 0;
        
        sortedLabels.forEach(label => {
            // Find data for this category and label
            const item = data.find(d => d.category === category && d.label === label);
            const count = item ? parseInt(item.count, 10) : 0;
            const ave = item ? parseFloat(item.total_ave) : 0;
            
            let countCell = document.createElement("td");
            countCell.textContent = count;
            countCell.style.border = "1px solid gray";
            row.appendChild(countCell);
            
            categoryTotal += count;
            categoryAve += ave;
        });

        // Add total column
        let totalCell = document.createElement("td");
        totalCell.textContent = categoryTotal;
        totalCell.style.border = "1px solid gray";
        row.appendChild(totalCell);

        // Add AVE column
        let aveCell = document.createElement("td");
        aveCell.textContent = categoryAve.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        aveCell.style.border = "1px solid gray";
        row.appendChild(aveCell);

        tableBody.appendChild(row);
    });

    // Add totals row
    let totalRow = document.createElement("tr");
    let totalLabelCell = document.createElement("td");
    totalLabelCell.textContent = "Grand Total";
    totalLabelCell.style.fontWeight = "bold";
    totalLabelCell.style.border = "1px solid gray";
    totalRow.appendChild(totalLabelCell);

    let grandTotal = 0;
    let grandTotalAve = 0;
    
    sortedLabels.forEach(label => {
        const labelTotal = data
            .filter(item => item.label === label)
            .reduce((sum, item) => sum + parseInt(item.count, 10), 0);
        
        let totalCell = document.createElement("td");
        totalCell.textContent = labelTotal;
        totalCell.style.fontWeight = "bold";
        totalCell.style.border = "1px solid gray";
        totalRow.appendChild(totalCell);
        
        grandTotal += labelTotal;
        
        // Calculate average for this label
        const labelItems = data.filter(item => item.label === label);
        if (labelItems.length > 0) {
            const labelAve = labelItems.reduce((sum, item) => sum + parseFloat(item.total_ave), 0);
            grandTotalAve += labelAve;
        }
    });

    // Add grand total column
    let grandTotalCell = document.createElement("td");
    grandTotalCell.textContent = grandTotal;
    grandTotalCell.style.fontWeight = "bold";
    grandTotalCell.style.border = "1px solid gray";
    totalRow.appendChild(grandTotalCell);

    // Add grand AVE column
    let grandAveCell = document.createElement("td");
    grandAveCell.textContent = grandTotalAve.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    grandAveCell.style.fontWeight = "bold";
    grandAveCell.style.border = "1px solid gray";
    totalRow.appendChild(grandAveCell);

    tableBody.appendChild(totalRow);
}


    function updateChart2(timeFrame) {
            let selectedData = sizeData[timeFrame];
            // Fill missing data based on time frame
    if (globalFromDate && globalToDate) {
        if (timeFrame === 'monthly') {
            selectedData = fillMissingMonthsGrouped(selectedData, globalFromDate, globalToDate);
        } else if (timeFrame === 'weekly') {
            selectedData = fillMissingWeeksGrouped(selectedData, globalFromDate, globalToDate);
        }
    }

            let labels = selectedData.map(item => `${formatDateLabel(item.label, timeFrame)} - ${item.category}`);
            let data = selectedData.map(item => item.count);

            updateChartData3(sizeAreaChart, labels, data);
            updateChartData3(sizePieChart, labels.slice(0, 3), data.slice(0, 3)); 
            updateChartData3(sizeBarChart, labels, data);
            updateChartData3(sizeLineChart, labels, data);
            updateChartData3(sizeVerticalBarChart, labels, data);

            console.log(`Updated size charts for: ${timeFrame}`);
            populateSizeTable(selectedData);
            console.log(`Updated charts and table for: ${timeFrame}`);
        }

    
        let mediaData = {
        daily: [],    // Initially empty, will be populated after AJAX success
        weekly: [],
        monthly: []
    };

    // Chart contexts
    const mediaAreaChartCtx = document.getElementById('MediaAreaChart').getContext('2d');
    const mediaPieChartCtx = document.getElementById('mediaPieChart').getContext('2d');
    const mediaBarChartCtx = document.getElementById('mediaBarChart').getContext('2d');
    const mediaLineChartCtx = document.getElementById('mediaLineChart').getContext('2d');
    const mediaVerticalBarChartCtx = document.getElementById('mediaVerticalBarChart').getContext('2d');

    // Initialize charts
    let MediaAreaChart = new Chart(mediaAreaChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    let mediaPieChart = new Chart(mediaPieChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.5)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                },
                {
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    stacked: true
                }
            }
        }
    });

    let mediaBarChart = new Chart(mediaBarChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    let mediaLineChart = new Chart(mediaLineChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    let mediaVerticalBarChart = new Chart(mediaVerticalBarChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    // Function to update chart data
    function updateChartData3(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets.forEach((dataset) => {
            dataset.data = data;
        });
        chart.update();
    }

    // Function to show the selected chart and populate quantity table
    function showChart3(chartId) {
            const charts = document.querySelectorAll('.chart-container-3');
            charts.forEach(chart => chart.classList.remove('active'));
            document.getElementById(chartId).classList.add('active');
            if (chartId === 'mediaShowTable') {
                populateMediaTable(mediaData.daily); 
            }
        }
        // Function to populate the quantity table with data
        function populateMediaTable(data) {
        const tableBody = document.querySelector("#mediaTable tbody");
        const tableHeader = document.querySelector("#mediaTable thead tr");

        // Clear existing headers and rows
        tableHeader.innerHTML = "";
        tableBody.innerHTML = "";

        let groupedData = {};

        data.forEach(item => {
            if (!groupedData[item.MediaType]) {
                groupedData[item.MediaType] = {};
            }
            if (!groupedData[item.MediaType][item.label]) {
                groupedData[item.MediaType][item.label] = {
                    count: 0,
                    total_ave: 0
                };
            }
            groupedData[item.MediaType][item.label].count += parseInt(item.count);
            groupedData[item.MediaType][item.label].total_ave += parseInt(item.total_ave);
        });

        let uniqueMonths = [...new Set(data.map(item => item.label))];
        let headerRow = "<th style='border: 1px solid gray;'>Media Type</th>";
        uniqueMonths.forEach(month => {
            headerRow += `<th style='border: 1px solid gray;'>${month}</th>`;
        });
        headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
        tableHeader.innerHTML = headerRow;

        Object.keys(groupedData).forEach(MediaType => {
            let row = document.createElement("tr");
            let MediaTypeCell = document.createElement("td");
            MediaTypeCell.textContent = MediaType || "N/A";
            MediaTypeCell.style.border = "1px solid gray";
            row.appendChild(MediaTypeCell);

            let totalAve = 0;
            uniqueMonths.forEach(month => {
                let count = groupedData[MediaType][month] ? groupedData[MediaType][month].count : 0;
                let countCell = document.createElement("td");
                countCell.textContent = count;
                countCell.style.border = "1px solid gray";
                row.appendChild(countCell);

                totalAve += groupedData[MediaType][month] ? groupedData[MediaType][month].total_ave : 0;
            });

            let aveCell = document.createElement("td");
            aveCell.textContent = totalAve;
            aveCell.style.border = "1px solid gray";
            row.appendChild(aveCell);

            tableBody.appendChild(row);
        });

        let totalRow = document.createElement("tr");
        let totalCell = document.createElement("td");
        totalCell.textContent = "Total";
        totalCell.style.border = "1px solid gray";
        totalRow.appendChild(totalCell);

        uniqueMonths.forEach(month => {
            let totalMonthCount = data.filter(item => item.label === month).reduce((acc, item) => acc + parseInt(item.count), 0);
            let totalMonthCell = document.createElement("td");
            totalMonthCell.textContent = totalMonthCount;
            totalMonthCell.style.border = "1px solid gray";
            totalRow.appendChild(totalMonthCell);
        });

        let totalAve = data.reduce((acc, item) => acc + parseInt(item.total_ave), 0);
        let totalAveCell = document.createElement("td");
        totalAveCell.textContent = totalAve;
        totalAveCell.style.border = "1px solid gray";
        totalRow.appendChild(totalAveCell);

        tableBody.appendChild(totalRow);
    }

        // Function to update all charts based on selected time frame
        function updateChart3(timeFrame) {
        let selectedData = mediaData[timeFrame];
        if (globalFromDate && globalToDate) {
        if (timeFrame === 'monthly') {
            selectedData = fillMissingMonthsGrouped(selectedData, globalFromDate, globalToDate);
        } else if (timeFrame === 'weekly') {
            selectedData = fillMissingWeeksGrouped(selectedData, globalFromDate, globalToDate);
        }
    }
        let labels = selectedData.map(item => `${formatDateLabel(item.label, timeFrame)} - ${item.MediaType}`);
        let data = selectedData.map(item => item.count);

        updateChartData3(MediaAreaChart, labels, data);
        updateChartData3(mediaPieChart, labels.slice(0, 3), data.slice(0, 3)); 
        updateChartData3(mediaBarChart, labels, data);
        updateChartData3(mediaLineChart, labels, data);
        updateChartData3(mediaVerticalBarChart, labels, data);

        console.log(`Updated size charts for: ${timeFrame}`);
        populateMediaTable(selectedData);
        console.log(`Updated charts and table for: ${timeFrame}`);
    }

    let publicationData = {
    daily: [],    // Initially empty, will be populated after AJAX success
    weekly: [],
    monthly: []
    };

    // Chart contexts
    const publicationAreaChartCtx = document.getElementById('publicationAreaChart').getContext('2d');
    const publicationPieChartCtx = document.getElementById('publicationPieChart').getContext('2d');
    const publicationBarChartCtx = document.getElementById('publicationBarChart').getContext('2d');
    const publicationLineChartCtx = document.getElementById('publicationLineChart').getContext('2d');
    const publicationVerticalBarChartCtx = document.getElementById('publicationVerticalBarChart').getContext('2d');

    // Initialize charts
    let publicationAreaChart = new Chart(publicationAreaChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

  let publicationPieChart = new Chart(publicationPieChartCtx, {
    type: 'bar', // Change the chart type to 'bar'
    data: {
        labels: [], // Add your labels here
        datasets: [{
            label: '', // Label for the first dataset
            data: [], // Add your data here
            backgroundColor: 'rgba(78, 115, 223, 0.5)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1
        },
        {
            label: '', // Label for the second dataset
            data: [], // Add your data here
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        ]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            x: {
                stacked: true // Stack the bars on the x-axis
            },
            y: {
                stacked: true, // Stack the bars on the y-axis
                ticks: {
                    stepSize: 1,
                    precision: 0,
                    callback: function(value) {
                        return value + '';
                    }
                }
            }
        }
    }
});


    let publicationBarChart = new Chart(publicationBarChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    let publicationLineChart = new Chart(publicationLineChartCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    let publicationVerticalBarChart = new Chart(publicationVerticalBarChartCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Expenses',
                data: [],
                backgroundColor: 'rgba(78, 115, 223, 1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        callback: function(value) {
                            return value + '';
                        }
                    }
                }
            }
        }
    });

    // Update chart data
    function updateChartData4(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets.forEach(dataset => {
            dataset.data = data;
        });
        chart.update();
    }

    // Function to show the selected chart and populate the publication table
    function showChart4(chartId) {
        const charts = document.querySelectorAll('.chart-container-4');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
        if (chartId === 'publicationShowTable') {
            populatePublicationTable(publicationData.daily); // Adjust according to your data structure
        }
        console.log(`Showing chart: ${chartId}`);
    }

    // Populate publication table
    function populatePublicationTable(data) {
        const tableBody = document.querySelector("#publicationTable tbody");
        const tableHeader = document.querySelector("#publicationTable thead tr");

        // Clear existing headers and rows
        tableHeader.innerHTML = "";
        tableBody.innerHTML = "";

        // Initialize an object to store grouped data
        let groupedData = {};

        // Group data by MediaOutlet and label
        data.forEach(item => {
            if (!groupedData[item.MediaOutlet]) {
                groupedData[item.MediaOutlet] = {};
            }
            if (!groupedData[item.MediaOutlet][item.label]) {
                groupedData[item.MediaOutlet][item.label] = {
                    count: 0,
                    total_ave: 0
                };
            }
            groupedData[item.MediaOutlet][item.label].count += parseInt(item.count);
            groupedData[item.MediaOutlet][item.label].total_ave += parseInt(item.total_ave);
        });

        // Prepare headers for each unique label
        let uniqueLabels = [...new Set(data.map(item => item.label))];
        let headerRow = "<th style='border: 1px solid gray;'>Media Outlet</th>";
        uniqueLabels.forEach(label => {
            headerRow += `<th style='border: 1px solid gray;'>${label}</th>`;
        });
        headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
        tableHeader.innerHTML = headerRow;

        // Loop through MediaOutlets to populate rows
        Object.keys(groupedData).forEach(MediaOutlet => {
            let row = document.createElement("tr");

            let MediaOutletCell = document.createElement("td");
            MediaOutletCell.textContent = MediaOutlet || "N/A";
            MediaOutletCell.style.border = "1px solid gray";
            row.appendChild(MediaOutletCell);

            // Populate counts for each label
            let totalAve = 0;
            uniqueLabels.forEach(label => {
                let count = groupedData[MediaOutlet][label] ? groupedData[MediaOutlet][label].count : 0;
                let countCell = document.createElement("td");
                countCell.textContent = count;
                countCell.style.border = "1px solid gray";
                row.appendChild(countCell);

                if (groupedData[MediaOutlet][label]) {
                    totalAve += groupedData[MediaOutlet][label].total_ave;
                }
            });

            let aveCell = document.createElement("td");
            aveCell.textContent = totalAve;
            aveCell.style.border = "1px solid gray";
            row.appendChild(aveCell);

            tableBody.appendChild(row);
        });

        // Add a row for totals
        let totalRow = document.createElement("tr");
        let totalCell = document.createElement("td");
        totalCell.textContent = "Total";
        totalCell.style.border = "1px solid gray";
        totalRow.appendChild(totalCell);

        // Calculate totals across all labels
        uniqueLabels.forEach(label => {
            let totalLabelCount = 0;
            data.forEach(item => {
                if (item.label === label) {
                    totalLabelCount += parseInt(item.count);
                }
            });

            let totalLabelCell = document.createElement("td");
            totalLabelCell.textContent = totalLabelCount;
            totalLabelCell.style.border = "1px solid gray";
            totalRow.appendChild(totalLabelCell);
        });

        // Calculate total average across all labels
        let totalAve = data.reduce((sum, item) => sum + parseInt(item.total_ave), 0);

        let totalAveCell = document.createElement("td");
        totalAveCell.textContent = totalAve;
        totalAveCell.style.border = "1px solid gray";
        totalRow.appendChild(totalAveCell);

        tableBody.appendChild(totalRow);
    }

    // Update charts and table based on the selected timeframe
    function updateChart4(timeFrame) {
        let selectedData = publicationData[timeFrame];
        if (globalFromDate && globalToDate) {
        if (timeFrame === 'monthly') {
            selectedData = fillMissingMonthsGrouped(selectedData, globalFromDate, globalToDate);
        } else if (timeFrame === 'weekly') {
            selectedData = fillMissingWeeksGrouped(selectedData, globalFromDate, globalToDate);
        }
    }
        let labels = selectedData.map(item => `${formatDateLabel(item.label, timeFrame)} - ${item.MediaOutlet}`);
        let data = selectedData.map(item => item.count);

        updateChartData4(publicationAreaChart, labels, data);
        updateChartData4(publicationPieChart, labels.slice(0, 3), data.slice(0, 3)); 
        updateChartData4(publicationBarChart, labels, data);
        updateChartData4(publicationLineChart, labels, data);
        updateChartData4(publicationVerticalBarChart, labels, data);

        console.log(`Updated publication charts for: ${timeFrame}`);
        populatePublicationTable(selectedData);
        console.log(`Updated publication table for: ${timeFrame}`);
    }

    // Initialize empty arrays for different timeframes
        let geographyData = {
            daily: [],
            weekly: [],
            monthly: []
        }; 
        const geographyAreaChartCtx = document.getElementById('geographyAreaChart').getContext('2d');
        const geographyPieChartCtx = document.getElementById('geographyPieChart').getContext('2d');
        const geographyBarChartCtx = document.getElementById('geographyBarChart').getContext('2d');
        const geographyLineChartCtx = document.getElementById('geographyLineChart').getContext('2d');
        const geographyVerticalBarChartCtx = document.getElementById('geographyVerticalBarChart').getContext('2d');

        // Initialize the charts with empty data
        let geographyAreaChart = new Chart(geographyAreaChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Earnings',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let geographyPieChart = new Chart(geographyPieChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(78, 115, 223, 0.5)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });

        let geographyBarChart = new Chart(geographyBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let geographyLineChart = new Chart(geographyLineChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let geographyVerticalBarChart = new Chart(geographyVerticalBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        // Function to update the chart data
        function updateChartData5(chart, labels, data) {
            chart.data.labels = labels;
            chart.data.datasets.forEach(dataset => {
                dataset.data = data;
            });
            chart.update();
        }

        // Function to show the appropriate chart and populate the table
        function showChart5(chartId) {
            const charts = document.querySelectorAll('.chart-container-5');
            charts.forEach(chart => {
                chart.classList.remove('active');
            });
            document.getElementById(chartId).classList.add('active');
            if (chartId === 'geographyShowTable') {
                populateGeographyTable(geographyData.daily); // Adjust according to your data structure
            }
            console.log(`Showing chart: ${chartId}`);
        }

        // Function to populate the geography table with data
        function populateGeographyTable(data) {
            const tableBody = document.querySelector("#geographyTable tbody");
            const tableHeader = document.querySelector("#geographyTable thead tr");
            
            // Clear existing headers and rows
            tableHeader.innerHTML = "";
            tableBody.innerHTML = "";

            // Initialize an object to store grouped data
            let groupedData = {};

            // Group data by MediaOutlet and label
            data.forEach(item => {
                if (!groupedData[item.Edition]) {
                    groupedData[item.Edition] = {};
                }
                if (!groupedData[item.Edition][item.label]) {
                    groupedData[item.Edition][item.label] = {
                        count: 0,
                        total_ave: 0
                    };
                }
                groupedData[item.Edition][item.label].count += parseInt(item.count);
                groupedData[item.Edition][item.label].total_ave += parseInt(item.total_ave);
            });

            // Prepare headers for each unique label
            let uniqueLabels = [...new Set(data.map(item => item.label))];
            let headerRow = "<th style='border: 1px solid gray;'>Geography</th>";
            uniqueLabels.forEach(label => {
                headerRow += `<th style='border: 1px solid gray;'>${label}</th>`;
            });
            headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
            tableHeader.innerHTML = headerRow;

            // Loop through MediaOutlets to populate rows
            Object.keys(groupedData).forEach(Edition => {
                let row = document.createElement("tr");

                let MediaOutletCell = document.createElement("td");
                MediaOutletCell.textContent = Edition || "N/A";
                MediaOutletCell.style.border = "1px solid gray";
                row.appendChild(MediaOutletCell);

                // Populate counts for each label
                let totalAve = 0;
                uniqueLabels.forEach(label => {
                    let count = groupedData[Edition][label] ? groupedData[Edition][label].count : 0;
                    let countCell = document.createElement("td");
                    countCell.textContent = count;
                    countCell.style.border = "1px solid gray";
                    row.appendChild(countCell);

                    if (groupedData[Edition][label]) {
                        totalAve += groupedData[Edition][label].total_ave;
                    }
                });

                let aveCell = document.createElement("td");
                aveCell.textContent = totalAve;
                aveCell.style.border = "1px solid gray";
                row.appendChild(aveCell);

                tableBody.appendChild(row);
            });

            // Add a row for totals
            let totalRow = document.createElement("tr");
            let totalCell = document.createElement("td");
            totalCell.textContent = "Total";
            totalCell.style.border = "1px solid gray";
            totalRow.appendChild(totalCell);

            // Calculate totals across all labels
            uniqueLabels.forEach(label => {
                let totalLabelCount = 0;
                data.forEach(item => {
                    if (item.label === label) {
                        totalLabelCount += parseInt(item.count);
                    }
                });

                let totalLabelCell = document.createElement("td");
                totalLabelCell.textContent = totalLabelCount;
                totalLabelCell.style.border = "1px solid gray";
                totalRow.appendChild(totalLabelCell);
            });

            // Calculate total average across all labels
            let totalAve = data.reduce((sum, item) => sum + parseInt(item.total_ave), 0);

            let totalAveCell = document.createElement("td");
            totalAveCell.textContent = totalAve;
            totalAveCell.style.border = "1px solid gray";
            totalRow.appendChild(totalAveCell);

            tableBody.appendChild(totalRow);
        }
        // Update charts and table based on the selected timeframe
        function updateChart5(timeFrame) {
            let selectedData = geographyData[timeFrame];
            if (globalFromDate && globalToDate) {
        if (timeFrame === 'monthly') {
            selectedData = fillMissingMonthsGrouped(selectedData, globalFromDate, globalToDate);
        } else if (timeFrame === 'weekly') {
            selectedData = fillMissingWeeksGrouped(selectedData, globalFromDate, globalToDate);
        }
    }
            let labels = selectedData.map(item => `${formatDateLabel(item.label, timeFrame)} - ${item.Edition}`);
            let data = selectedData.map(item => item.count);

            updateChartData5(geographyAreaChart, labels, data);
            updateChartData5(geographyPieChart, labels.slice(0, 3), data.slice(0, 3)); 
            updateChartData5(geographyBarChart, labels, data);
            updateChartData5(geographyLineChart, labels, data);
            updateChartData5(geographyVerticalBarChart, labels, data);

            console.log(`Updated Geography charts for: ${timeFrame}`);
            populateGeographyTable(selectedData);
            console.log(`Updated Geography table for: ${timeFrame}`);
        }
        
        let journalistData = {
                daily: [],
                weekly: [],
                monthly: []
            };

            const journalistAreaChartCtx = document.getElementById('journalistAreaChart').getContext('2d');
            const journalistPieChartCtx = document.getElementById('journalistPieChart').getContext('2d');
            const journalistBarChartCtx = document.getElementById('journalistBarChart').getContext('2d');
            const journalistLineChartCtx = document.getElementById('journalistLineChart').getContext('2d');
            const journalistVerticalBarChartCtx = document.getElementById('journalistVerticalBarChart').getContext('2d');

        // Initialize charts
        let journalistAreaChart = new Chart(journalistAreaChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Earnings',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let journalistPieChart = new Chart(journalistPieChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(78, 115, 223, 0.5)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });

        let journalistBarChart = new Chart(journalistBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let journalistLineChart = new Chart(journalistLineChartCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        let journalistVerticalBarChart = new Chart(journalistVerticalBarChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: 'rgba(78, 115, 223, 1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    }
                }
            }
        });

        // Function to update the chart data
        function updateChartData6(chart, labels, data) {
    chart.data.labels = labels;
    chart.data.datasets.forEach(dataset => {
        dataset.data = data;
    });
    chart.update();
}

// Function to show the appropriate chart and populate the table
function showChart6(chartId) {
    const charts = document.querySelectorAll('.chart-container-6');
    charts.forEach(chart => {
        chart.classList.remove('active');
    });
    document.getElementById(chartId).classList.add('active');
    if (chartId === 'journalistShowTable') {
        populateJournalistTable(journalistData.daily); // Adjust according to your data structure
    }
    console.log(`Showing chart: ${chartId}`);
}
// Function to populate the journalist table with data
function populateJournalistTable(data) {
    const tableBody = document.querySelector("#journalistTable tbody");
    const tableHeader = document.querySelector("#journalistTable thead tr");

    // Clear existing headers and rows
    tableHeader.innerHTML = "";
    tableBody.innerHTML = "";

    // Initialize an object to store grouped data
    let groupedData = {};

    // Group data by Journalist and label
    data.forEach(item => {
        if (!groupedData[item.Journalist]) {
            groupedData[item.Journalist] = {};
        }
        if (!groupedData[item.Journalist][item.label]) {
            groupedData[item.Journalist][item.label] = {
                count: 0,
                total_ave: 0
            };
        }
        groupedData[item.Journalist][item.label].count += parseInt(item.count);
        groupedData[item.Journalist][item.label].total_ave += parseInt(item.total_ave);
    });

    // Prepare headers for each unique label
    let uniqueLabels = [...new Set(data.map(item => item.label))];
    let headerRow = "<th style='border: 1px solid gray;'>Journalist</th>";
    uniqueLabels.forEach(label => {
        headerRow += `<th style='border: 1px solid gray;'>${label}</th>`;
    });
    headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
    tableHeader.innerHTML = headerRow;

    // Initialize totals
    let grandTotalCount = 0;
    let grandTotalAve = 0;

    // Loop through Journalists to populate rows
    Object.keys(groupedData).forEach(Journalist => {
        let row = document.createElement("tr");

        let journalistCell = document.createElement("td");
        journalistCell.textContent = Journalist || "N/A";
        journalistCell.style.border = "1px solid gray";
        row.appendChild(journalistCell);

        // Populate counts for each label
        let totalCount = 0;
        let totalAve = 0;
        uniqueLabels.forEach(label => {
            let count = groupedData[Journalist][label] ? groupedData[Journalist][label].count : 0;
            let ave = groupedData[Journalist][label] ? groupedData[Journalist][label].total_ave / groupedData[Journalist][label].count : 0;

            let countCell = document.createElement("td");
            countCell.textContent = count;
            countCell.style.border = "1px solid gray";
            row.appendChild(countCell);

            // Accumulate total count and total ave for this Journalist
            totalCount += count;
            totalAve += ave * count; // Multiplying average by count to get total average
        });

        // Add the average cell to the row
        let aveCell = document.createElement("td");
        aveCell.textContent = (totalAve / totalCount).toFixed(2); // Calculating average of averages
        aveCell.style.border = "1px solid gray";
        row.appendChild(aveCell);

        // Append the row to the table body
        tableBody.appendChild(row);

        // Update grand totals
        grandTotalCount += totalCount;
        grandTotalAve += totalAve;
    });

    // Add the total count row
    let totalRow = document.createElement("tr");

    let totalLabelCell = document.createElement("td");
    totalLabelCell.textContent = "Total Count";
    totalLabelCell.style.border = "1px solid gray";
    totalRow.appendChild(totalLabelCell);


    let totalCountCell = document.createElement("td");
    totalCountCell.textContent = grandTotalCount;
    totalCountCell.style.border = "1px solid gray";
    totalRow.appendChild(totalCountCell);

    let totalAveCell = document.createElement("td");
    totalAveCell.textContent = (grandTotalAve / grandTotalCount).toFixed(2); // Calculating overall average
    totalAveCell.style.border = "1px solid gray";
    totalRow.appendChild(totalAveCell);

    tableBody.appendChild(totalRow);
}



// Global variables to store date range
let globalFromDate = null;
    let globalToDate = null;

function generateAllMonths(fromDate, toDate) {
    const months = [];
    const start = new Date(fromDate + 'T00:00:00');
    const end = new Date(toDate + 'T00:00:00');
    
    const current = new Date(start.getFullYear(), start.getMonth(), 1);
    const endMonth = new Date(end.getFullYear(), end.getMonth(), 1);
    
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];
    
    while (current <= endMonth) {
        const year = current.getFullYear();
        const monthName = monthNames[current.getMonth()];
        months.push(`${monthName} ${year}`);
        current.setMonth(current.getMonth() + 1);
    }
    
    return months;
}

function fillMissingMonths(data, fromDate, toDate) {
        if (!fromDate || !toDate) return data;
        
        const allMonths = generateAllMonths(fromDate, toDate);
        const dataMap = new Map();
        
        // Create a map of existing data by label (month)
        data.forEach(item => {
            dataMap.set(item.label, item);
        });
        
        // Fill in missing months with zero values
        const filledData = allMonths.map(month => {
            if (dataMap.has(month)) {
                return dataMap.get(month);
            } else {
                // Return zero value object based on the structure of the first item
                if (data.length > 0) {
                    const sample = data[0];
                    const zeroItem = { label: month, count: 0 };
                    // Copy other properties from sample with zero values
                    if (sample.total_ave !== undefined) zeroItem.total_ave = 0;
                    if (sample.category !== undefined) zeroItem.category = sample.category;
                    if (sample.MediaType !== undefined) zeroItem.MediaType = sample.MediaType;
                    if (sample.MediaOutlet !== undefined) zeroItem.MediaOutlet = sample.MediaOutlet;
                    if (sample.Edition !== undefined) zeroItem.Edition = sample.Edition;
                    if (sample.Journalist !== undefined) zeroItem.Journalist = sample.Journalist;
                    return zeroItem;
                } else {
                    return { label: month, count: 0, total_ave: 0 };
                }
            }
        });
        
        return filledData;
    }

function fillMissingMonthsGrouped(data, fromDate, toDate) {
        if (!fromDate || !toDate || data.length === 0) return data;
        
        const allMonths = generateAllMonths(fromDate, toDate);
        const groupedByCategory = {};
        const categories = new Set();
        
        // Group data by category (MediaType, MediaOutlet, Edition, Journalist, category)
        data.forEach(item => {
            const categoryKey = item.MediaType || item.MediaOutlet || item.Edition || item.Journalist || item.category || 'default';
            categories.add(categoryKey);
            if (!groupedByCategory[categoryKey]) {
                groupedByCategory[categoryKey] = {};
            }
            groupedByCategory[categoryKey][item.label] = item;
        });
        
        // Fill missing months for each category
        const filledData = [];
        categories.forEach(categoryKey => {
            allMonths.forEach(month => {
                if (groupedByCategory[categoryKey][month]) {
                    filledData.push(groupedByCategory[categoryKey][month]);
                } else {
                    const sample = data.find(item => {
                        const key = item.MediaType || item.MediaOutlet || item.Edition || item.Journalist || item.category;
                        return key === categoryKey;
                    });
                    if (sample) {
                        const zeroItem = { label: month, count: 0, total_ave: 0 };
                        if (sample.MediaType !== undefined) zeroItem.MediaType = sample.MediaType;
                        if (sample.MediaOutlet !== undefined) zeroItem.MediaOutlet = sample.MediaOutlet;
                        if (sample.Edition !== undefined) zeroItem.Edition = sample.Edition;
                        if (sample.Journalist !== undefined) zeroItem.Journalist = sample.Journalist;
                        if (sample.category !== undefined) zeroItem.category = sample.category;
                        filledData.push(zeroItem);
                    }
                }
            });
        });
        
        return filledData;
    }

// Function to update the chart based on the selected timeframe
function updateChart6(timeframe) {
    let selectedData = journalistData[timeframe];

    if (globalFromDate && globalToDate) {
        if (timeframe === 'monthly') {
            selectedData = fillMissingMonthsGrouped(selectedData, globalFromDate, globalToDate);
        } else if (timeframe === 'weekly') {
            selectedData = fillMissingWeeksGrouped(selectedData, globalFromDate, globalToDate);
        }
    }

    let labels = selectedData.map(item => `${formatDateLabel(item.label, timeframe)} - ${item.Journalist}`);
    let data = selectedData.map(item => item.count);

    updateChartData6(journalistAreaChart, labels, data);
    updateChartData6(journalistPieChart, labels.slice(0, 3), data.slice(0, 3));
    updateChartData6(journalistBarChart, labels, data);
    updateChartData6(journalistLineChart, labels, data);
    updateChartData6(journalistVerticalBarChart, labels, data);

    populateJournalistTable(selectedData);
}
    function handleChartTypeChange() {
        const selectedValue = document.getElementById('chartTypeSelector').value;
        const quantityCharts = document.querySelector('.quantity');
        const mediaCharts = document.querySelector('.media');
        const publicationCharts = document.querySelector('.publication');
        const geographyCharts = document.querySelector('.geography');
        const journalistCharts = document.querySelector('.journalist');
        const sizeCharts = document.querySelector('.size');
        if (selectedValue === 'Quantity') {
            quantityCharts.style.display = 'block';
            mediaCharts.style.display = 'none';
            publicationCharts.style.display = 'none';
            geographyCharts.style.display = 'none';
            journalistCharts.style.display = 'none';
            sizeCharts.style.display = 'none';
        } else if (selectedValue === 'Media') {
            quantityCharts.style.display = 'none';
            mediaCharts.style.display = 'block';
            publicationCharts.style.display = 'none';
            geographyCharts.style.display = 'none';
            journalistCharts.style.display = 'none';
            sizeCharts.style.display = 'none';
        } else if (selectedValue === 'Publication') {
            quantityCharts.style.display = 'none';
            mediaCharts.style.display = 'none';
            publicationCharts.style.display = 'block';
            geographyCharts.style.display = 'none';
            journalistCharts.style.display = 'none';
            sizeCharts.style.display = 'none';
        }else if (selectedValue === 'Geography') {
            quantityCharts.style.display = 'none';
            mediaCharts.style.display = 'none';
            publicationCharts.style.display = 'none';
            geographyCharts.style.display = 'block';
            journalistCharts.style.display = 'none';
            sizeCharts.style.display = 'none';
        }else if (selectedValue === 'Journalist') {
            quantityCharts.style.display = 'none';
            mediaCharts.style.display = 'none';
            publicationCharts.style.display = 'none';
            geographyCharts.style.display = 'none';
            journalistCharts.style.display = 'block';
            sizeCharts.style.display = 'none';
        }else if (selectedValue === 'Size') {
            quantityCharts.style.display = 'none';
            mediaCharts.style.display = 'none';
            publicationCharts.style.display = 'none';
            geographyCharts.style.display = 'none';
            journalistCharts.style.display = 'none';
            sizeCharts.style.display = 'block';
    }
    }
    updateChart('daily');
    showChart('lineChart');
    updateChart3('daily');
    showChart3('mediaLineChart');
    updateChart4('daily');
    showChart4('mediaLineChart');
 
    handleChartTypeChange();

</script>
</div>
</div>
@include('common/clientDashboard_footer')