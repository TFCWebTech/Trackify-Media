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
                // Update charts and table with daily data as default
                updateChart('daily');
                showChart('lineChart'); // Show the line chart by default
                updateChart3('daily');
                showChart3('mediaLineChart'); // Show the line chart by default
                updateChart4('daily');
                showChart4('publicationLineChart'); // Show the line chart by default
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
        let labels = selectedData.map(item => `${item.label} - ${item.MediaType}`);
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
                    callback: function(value) {
                        return value + '';
                    }
                }
            }
        }
    }
});

let publicationPieChart = new Chart(publicationPieChartCtx, {
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
                    callback: function(value) {
                        return value + '';
                    }
                }
            }
        }
    }
});

  function updateChartData4(chart, labels, data) {
    chart.data.labels = labels;
    chart.data.datasets.forEach(dataset => {
        dataset.data = data;
    });
    chart.update();
}

    // Function to show the selected chart and populate quantity table
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
function populatePublicationTable(data) {
    const tableBody = document.querySelector("#publicationTable tbody");
    const tableHeader = document.querySelector("#publicationTable thead tr");

    // Clear existing headers and rows
    tableHeader.innerHTML = "";
    tableBody.innerHTML = "";

    // Initialize an object to store grouped data
    let groupedData = {};

    // Group data by category and month
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

    // Prepare headers for each unique month
    let uniqueMonths = [...new Set(data.map(item => item.label))];
    let headerRow = "<th style='border: 1px solid gray;'>Media Outlet</th>";
    uniqueMonths.forEach(month => {
        headerRow += `<th style='border: 1px solid gray;'>${month}</th>`;
    });
    headerRow += "<th style='border: 1px solid gray;'>AVE</th>";
    tableHeader.innerHTML = headerRow;

    // Loop through categories to populate rows
    Object.keys(groupedData).forEach(MediaOutlet => {
        let row = document.createElement("tr");

        let MediaOutletCell = document.createElement("td");
        MediaOutletCell.textContent = MediaOutlet || "N/A";
        MediaOutletCell.style.border = "1px solid gray";
        row.appendChild(MediaOutletCell);

        // Populate counts for each month
        let totalAve = 0;
        uniqueMonths.forEach(month => {
            let count = groupedData[MediaOutlet][month] ? groupedData[MediaOutlet][month].count : 0;
            let countCell = document.createElement("td");
            countCell.textContent = count;
            countCell.style.border = "1px solid gray";
            row.appendChild(countCell);
        });

        // Calculate and populate average values for each category
        uniqueMonths.forEach(month => {
            totalAve += groupedData[MediaOutlet][month] ? groupedData[MediaOutlet][month].total_ave : 0;
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

    // Calculate totals across all months
    uniqueMonths.forEach(month => {
        let totalMonthCount = 0;
        data.forEach(item => {
            if (item.label === month) {
                totalMonthCount += parseInt(item.count);
            }
        });

        let totalMonthCell = document.createElement("td");
        totalMonthCell.textContent = totalMonthCount;
        totalMonthCell.style.border = "1px solid gray";
        totalRow.appendChild(totalMonthCell);
    });

    // Calculate total average across all months
    let totalAve = 0;
    data.forEach(item => {
        totalAve += parseInt(item.total_ave);
    });

    let totalAveCell = document.createElement("td");
    totalAveCell.textContent = totalAve;
    totalAveCell.style.border = "1px solid gray";
    totalRow.appendChild(totalAveCell);

    tableBody.appendChild(totalRow);
}

    function handleChartTypeChange() {
        const selectedValue = document.getElementById('chartTypeSelector').value;
        const quantityCharts = document.querySelector('.quantity');
        const mdeiaCharts = document.querySelector('.media');
        const publicationCharts = document.querySelector('.publication');
        if (selectedValue === 'Quantity') {
            quantityCharts.style.display = 'block';
            mdeiaCharts.style.display = 'none';
            publicationCharts.style.display = 'none';
        } else if (selectedValue === 'Media') {
            quantityCharts.style.display = 'none';
            mdeiaCharts.style.display = 'block';
            publicationCharts.style.display = 'none';
        } else if (selectedValue === 'Publication') {
            quantityCharts.style.display = 'none';
            mdeiaCharts.style.display = 'none';
            publicationCharts.style.display = 'block';
        }
    }

    updateChart('daily');
    showChart('lineChart');
    updateChart3('daily');
    showChart3('mediaLineChart');
    handleChartTypeChange();

</script>
</div>
</div>
@include('common\footer')