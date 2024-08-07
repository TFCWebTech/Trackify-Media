@include('common\clientDashboard-header')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
    .chart-container-7 {
        display: none !important;
        height: 400px;
    }
    .chart-container-7.active {
        display: block !important;
        height: 400px;
    }
    label {
    font-size: 0.8rem !important;
    margin-top: 0.5rem !important;
}
.chart-container {
    display: none;
}

.chart-container.active {
    display: block;
}
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
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
            
        
            <div class="quantity">
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
                <div id="clientNewsCountContainer" class="chart-container"></div>
                
                <div class="my-4">
                    <button class="btn btn-primary" onclick="showChart('pieChart')">Pie Chart</button>
                    <button class="btn btn-primary" onclick="showChart('barChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart('lineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart('verticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart('clientNewsCountContainer')">Show Table</button>
                </div>
             </div>

             <div class="media">
           
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Media</h6>
                    </div>
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
                <div id="showMediaTableData" class="chart-container-3" style="display: none;">
                    <table id="mediaTable" style="width:100%; border: 1px solid gray;" >
                        <thead>
                            <tr >
                                <th style= "border: 1px solid gray;">Name</th>
                                <th style= "border: 1px solid gray;">Media Type</th>
                                <th style= "border: 1px solid gray;">Count</th>
                                <th style= "border: 1px solid gray;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <button class="btn btn-primary" onclick="showChart3('mediabarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('medialineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('mediaverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart3('showMediaTableData')">Table Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let areaChart = initializeChart('myAreaChart', 'line');
    let pieChart = initializeChart('myPieChart', 'doughnut');
    let barChart = initializeChart('myBarChart', 'bar');
    let lineChart = initializeChart('myLineChart', 'line');
    let verticalBarChart = initializeChart('myVerticalBarChart', 'bar');

    let mediaBarChart = initializeChart('mediaBarChart', 'bar');
    let mediaLineChart = initializeChart('mediaLineChart', 'line');
    let mediaVerticalBarChart = initializeChart('mediaVerticalBarChart', 'bar');
    
    function initializeChart(ctxId, type) {
        return new Chart(document.getElementById(ctxId).getContext('2d'), {
            type: type,
            data: {
                labels: [],
                datasets: []
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
    }
    $('#select_client').change(function() {
        const clientId = $(this).val();

        $.ajax({
            url: '{{ route('fetchClientData') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                select_client: clientId
            },
            success: function(response) {
                if (response.get_quantity_compare_data && response.media_data) {
                    updateCharts(response.get_quantity_compare_data);
                    updateMediaCharts(response.media_data);
                    updateClientNewsCount(response.get_quantity_compare_data);
                    console.log('Data fetched and charts updated.');
                } else {
                    console.error('Invalid data format received:', response);
                }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
            }
        });
    });

    function updateCharts(data) {
        let labels = [];
        let datasets = [{
            label: 'Quantity Data',
            data: [],
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 2,
            fill: true
        }];

        data.forEach(item => {
            labels.push(item.label);
            datasets[0].data.push(item.count);
        });

        updateChart(areaChart, labels, datasets);
        updateChart(pieChart, labels, datasets);
        updateChart(barChart, labels, datasets);
        updateChart(lineChart, labels, datasets);
        updateChart(verticalBarChart, labels, datasets);
    }

    function updateChart(chart, labels, datasets) {
        chart.data.labels = labels;
        chart.data.datasets = datasets;
        chart.update();
    }

    function updateMediaCharts(news_data) {
        let mediaLabels = [];
        let lineDataset = [];
        let barDataset = [];
        let columnDataset = [];
        let clientNames = new Set();

        for (let mediaType in news_data) {
            if (news_data.hasOwnProperty(mediaType)) {
                mediaLabels.push(mediaType);

                news_data[mediaType].forEach(news => clientNames.add(news.Client_name));
            }
        }

        let finalData = Array.from(clientNames).map(clientName => {
            let counts = [];
            for (let mediaType in news_data) {
                let mediaData = news_data[mediaType];
                let countData = mediaData.find(news => news.Client_name === clientName);
                counts.push(countData ? countData.Count : 0);
            }
            return {
                label: clientName,
                count: counts
            };
        });

        finalData.forEach(dataItem => {
            let color = getRandomColor(0.1);
            lineDataset.push({
                label: dataItem.label,
                data: dataItem.count,
                backgroundColor: color.background,
                borderColor: color.border,
                borderWidth: 2,
                fill: true
            });

            barDataset.push({
                label: dataItem.label,
                data: dataItem.count,
                backgroundColor: color.background,
                borderColor: color.border,
                borderWidth: 1
            });

            columnDataset.push({
                label: dataItem.label,
                data: dataItem.count,
                backgroundColor: color.background,
                borderColor: color.border,
                borderWidth: 1
            });
        });

        updateChart(mediaBarChart, mediaLabels, barDataset);
        updateChart(mediaLineChart, mediaLabels, lineDataset);
        updateChart(mediaVerticalBarChart, mediaLabels, columnDataset);
    }
    function getRandomColor(opacity) {
        let r = Math.floor(Math.random() * 255);
        let g = Math.floor(Math.random() * 255);
        let b = Math.floor(Math.random() * 255);
        return {
            background: `rgba(${r}, ${g}, ${b}, ${opacity})`,
            border: `rgba(${r}, ${g}, ${b}, 1)`
        };
    }

    function updateClientNewsCount(data) {
        const container = document.getElementById('clientNewsCountContainer');
        container.innerHTML = '';

        const table = document.createElement('table');
        table.style.width = '100%';
        table.innerHTML = `
            <tr>
                <th>Company Name</th>
                <th>Count</th>
                <th>AVE</th>
            </tr>
        `;

        let totalCount = 0;
        let totalAve = 0;
        let aveCount = 0;

        data.forEach(client => {
            const row = document.createElement('tr');
            const aveValue = client.ave !== undefined && client.ave !== null ? client.ave : 0;
            row.innerHTML = `
                <td>${client.label}</td>
                <td>${client.count}</td>
                <td>${aveValue}</td>
            `;
            table.appendChild(row);

            totalCount += parseInt(client.count, 10);
            totalAve += parseFloat(aveValue);
            aveCount += aveValue ? 1 : 0;
        });

        const avgAve = aveCount > 0 ? (totalAve / aveCount).toFixed(2) : 0;

        const totalRow = document.createElement('tr');
        totalRow.style.fontWeight = 'bold';
        totalRow.innerHTML = `
            <td>Total</td>
            <td>${totalCount}</td>
            <td>${avgAve}</td>
        `;
        table.appendChild(totalRow);
        container.appendChild(table);
    }
    window.showChart = function(chartId) {
        const charts = document.querySelectorAll('.chart-container');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }

    window.showChart3 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-3');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }

    window.handleChartTypeChange = function() {
        const selectedValue = document.getElementById('chartTypeSelector').value;
        const quantityCharts = document.querySelector('.quantity');
        const mediaCharts = document.querySelector('.media');

        quantityCharts.style.display = selectedValue === 'Quantity' ? 'block' : 'none';
        mediaCharts.style.display = selectedValue === 'Media' ? 'block' : 'none';
    }

    showChart('lineChart');
    showChart3('mediaLineChart');
    handleChartTypeChange();
</script>
<script>
        function getCurrentDate() {
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        document.getElementById('to-date').value = getCurrentDate();
    </script>
@include('common\footer')