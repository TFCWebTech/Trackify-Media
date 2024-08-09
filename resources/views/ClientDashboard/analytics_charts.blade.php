@include('common\clientDashboard-header')
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
                                &nbsp;<button type="submit" class="bg-primary border-primary text-light"> <i class="fa fa-search "></i></button> 
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
                                <option value="ave">AVE</option>
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
                    <canvas id="myPieChart"></canvas>
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
                                <th style="border: 1px solid gray;">Day</th>
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
                    <button class="btn btn-primary" onclick="showChart('pieChart')">Pie Chart</button>
                    <button class="btn btn-primary" onclick="showChart('barChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart('lineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart('verticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart('quantityShowTable')">Show Table</button>

                </div>
            </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $('#select_client').change(function() {
    const clientId = $(this).val();

    $.ajax({
        url: '{{ route('fetchAnalyticsData') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            select_client: clientId
        },
        success: function(response) {
            console.log(response);

            // Assuming response contains quantity_graph_daily, quantity_graph_weekly, and quantity_graph_monthly
            quantityData = {
                daily: response.quantity_graph_daily,
                weekly: response.quantity_graph_weekly,
                monthly: response.quantity_graph_monthly
            };

            // Update charts and table with daily data as default
            updateChart('daily');
            showChart('lineChart'); // Show the line chart by default

        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
        }
    });
});


    let quantityData = {
        daily: [],    // Initially empty, will be populated after AJAX success
        weekly: [],
        monthly: []
    };

    // Chart contexts
    const areaChartCtx = document.getElementById('myAreaChart').getContext('2d');
    const pieChartCtx = document.getElementById('myPieChart').getContext('2d');
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
            populateQuantityTable(quantityData.daily); 
        }
    }

    // Function to populate the quantity table with data
    function populateQuantityTable(data) {
        const tableBody = document.querySelector("#quantityTable tbody");
        tableBody.innerHTML = ""; 

        let totalNewsCount = 0;
        let totalAve = 0;

        data.forEach(item => {
            let row = document.createElement("tr");

            let labelCell = document.createElement("td");
            labelCell.textContent = item.label || "N/A";
            labelCell.style.border = "1px solid gray"; 
            row.appendChild(labelCell);

            let countCell = document.createElement("td");
            countCell.textContent = item.count || "N/A";
            countCell.style.border = "1px solid gray"; 
            row.appendChild(countCell);

            let aveCell = document.createElement("td");
            aveCell.textContent = item.total_ave ? item.total_ave.toLocaleString() : "N/A";
            aveCell.style.border = "1px solid gray"; 
            row.appendChild(aveCell);

            tableBody.appendChild(row);

            // Calculate totals
            totalNewsCount += item.count || 0;
            totalAve += item.total_ave || 0;
        });

        // Add a summary row for totals
        let totalRow = document.createElement("tr");

        let totalLabelCell = document.createElement("td");
        totalLabelCell.textContent = "Total";
        totalLabelCell.style.fontWeight = "bold";
        totalLabelCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalLabelCell);

        let totalCountCell = document.createElement("td");
        totalCountCell.textContent = totalNewsCount;
        totalCountCell.style.fontWeight = "bold";
        totalCountCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalCountCell);

        let totalAveCell = document.createElement("td");
        totalAveCell.textContent = totalAve ? totalAve.toLocaleString() : "N/A";
        totalAveCell.style.fontWeight = "bold";
        totalAveCell.style.border = "1px solid gray"; 
        totalRow.appendChild(totalAveCell);

        tableBody.appendChild(totalRow);
    }

    // Function to update all charts based on selected time frame
    function updateChart(timeFrame) {
        let data = [];
        let labels = [];
        let selectedData = quantityData[timeFrame]; 

        selectedData.forEach(item => {
            labels.push(item.label);
            data.push(item.count);
        });

        updateChartData(areaChart, labels, data);
        updateChartData(pieChart, labels.slice(0, 3), data.slice(0, 3)); 
        updateChartData(barChart, labels, data);
        updateChartData(lineChart, labels, data);
        updateChartData(verticalBarChart, labels, data);

        populateQuantityTable(selectedData);
    }

    // Function to update data for a given chart
    function updateChartData(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets.forEach(dataset => {
            dataset.data = data;
        });
        chart.update();
    }

    function handleChartTypeChange() {
        const selectedValue = document.getElementById('chartTypeSelector').value;
        const quantityCharts = document.querySelector('.quantity');
        const sizeCharts = document.querySelector('.size');

        if (selectedValue === 'Quantity') {
            quantityCharts.style.display = 'block';
            sizeCharts.style.display = 'none';
        } else if (selectedValue === 'Size') {
            quantityCharts.style.display = 'none';
            sizeCharts.style.display = 'block';
        }
    }

    updateChart('daily');
    showChart('lineChart');
    handleChartTypeChange();
</script>
</div>
</div>
@include('common\footer')