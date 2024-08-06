@include('common\clientDashboard-header')
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
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-md-12 d-flex justify-content-between ">
                <div class="div d-flex">
                        <form action="" method="post" class="d-flex" style="height:35px;">
                            <label class="px-1 font-weight-bold mt-1" for="publication_type">Select Client</label>
                                <select class="form-control" name="select_client" id="select_client" style="width:200px;">
                                    <option disbled>Select</option>
                                     
                            </select>
                            &nbsp; <button type="submit" class="bg-primary border-primary text-light"> <i class="fa fa-search "></i></button>
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
                <div class="client-news-count chart-container" id="showDataInTable">
                    <div class="row">
                        <!-- <div class="col-md-12 text-left">
                            <h6 class="text-primary">Client News Count</h6>
                        </div> -->
                    </div>
                    <div id="clientNewsCountContainer">
                        <!-- Client news count will be dynamically inserted here -->
                    </div>
                </div>
                <div class="my-4">
                    <!-- <button class="btn btn-primary" onclick="showChart('areaChart')">Area Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart('pieChart')">Pie Chart</button>
                    <button class="btn btn-primary" onclick="showChart('barChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart('lineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart('verticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart('showDataInTable')">Show Table</button>
                </div>
            </div>

            <hr>
            <div class="size">
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
                <div id="showSizeTableData" class="chart-container-2" style="display: none;">
                    <table id="sizeTable" style="width:100%; border: 1px solid gray;" >
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
                    <!-- <button class="btn btn-primary" onclick="showChart2('sizeareaChart')">Area Chart</button> -->
                    <!-- <button class="btn btn-primary" onclick="showChart2('sizepieChart')">Pie Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart2('sizebarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizelineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizeverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('showSizeTableData')">Table Data</button>
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
            <div class="publication">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Publication</h6>
                    </div>
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
                <div id="showPublicationTableData" class="chart-container-4" style="display: none;">
                    <table id="publicationTable" style="width:100%; border: 1px solid gray;" >
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
                    <button class="btn btn-primary" onclick="showChart4('publicationbarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart4('publicationlineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart4('publicationverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart4('showPublicationTableData')">Table Data</button>
                </div>
            </div>
            <div class="geography">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">SOV / Geography</h6>
                    </div>
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
                <div id="showGeographyTableData" class="chart-container-5" style="display: none;">
                    <table id="geographyTable" style="width:100%; border: 1px solid gray;" >
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
                    <button class="btn btn-primary" onclick="showChart5('geographybarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographylineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('geographyverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart5('showGeographyTableData')">Table Data</button>
                </div>
            </div>

            <div class="journalist">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Journalist</h6>
                    </div>
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
                <div id="showJournalistTableData" class="chart-container-6" style="display: none;">
                    <table id="journalistTable" style="width:100%; border: 1px solid gray;" >
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
                    <!-- <button class="btn btn-primary" onclick="showChart6('journalistareaChart')">Area Chart</button> -->
                    <!-- <button class="btn btn-primary" onclick="showChart6('journalistpieChart')">Pie Chart</button> -->
                    <button class="btn btn-primary" onclick="showChart6('journalistbarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistlineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('journalistverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart6('showJournalistTableData')">Table Data</button>
                </div>
            </div>

            <div class="ave">
           
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Media</h6>
                    </div>
                </div>
               <div id="aveareaChart" class="chart-container-7">
                    <canvas id="aveAreaChart"></canvas>
                </div>
                <div id="avepieChart" class="chart-container-7">
                    <canvas id="avePieChart"></canvas>
                </div>
                <div id="avebarChart" class="chart-container-7">
                    <canvas id="aveBarChart"></canvas>
                </div>
                <div id="avelineChart" class="chart-container-7">
                    <canvas id="aveLineChart"></canvas>
                </div>
                <div id="aveverticalBarChart" class="chart-container-7">
                    <canvas id="aveVerticalBarChart"></canvas>
                </div>
                <div id="showAveTableData" class="chart-container-7" style="display: none;">
                    <table id="aveTable" style="width:100%;">
                        <thead>
                            <tr style="border= 1px solid gray;">
                                <th style="border: 1px solid black;">Company Name</th>
                                <th style="border: 1px solid black;">AVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <button class="btn btn-primary" onclick="showChart7('avepieChart')">Pie Chart</button>
                    <button class="btn btn-primary" onclick="showChart7('avebarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart7('avelineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart7('aveverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart7('showAveTableData')">Table Data</button>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const areaChartCtx = document.getElementById('myAreaChart').getContext('2d');
        const pieChartCtx = document.getElementById('myPieChart').getContext('2d');
        const barChartCtx = document.getElementById('myBarChart').getContext('2d');
        const lineChartCtx = document.getElementById('myLineChart').getContext('2d');
        const verticalBarChartCtx = document.getElementById('myVerticalBarChart').getContext('2d');

        let areaChart = new Chart(areaChartCtx, {
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

        let pieChart = new Chart(pieChartCtx, {
            type: 'doughnut',
            data: {
                labels: [],
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

        function showChart(chartId) {
            const charts = document.querySelectorAll('.chart-container');
            charts.forEach(chart => {
                chart.classList.remove('active');
            });
            document.getElementById(chartId).classList.add('active');
            console.log(`Showing chart: ${chartId}`);
        }

        function updateClientNewsCount(data) {
            const container = document.getElementById('clientNewsCountContainer');
            container.innerHTML = '';

            const table = document.createElement('table');
            table.style.width = '100%';
            table.innerHTML = `
                <tr style="border: 1px solid #dddddd;">
                    <th style="border: 1px solid #dddddd;">Company Name</th>
                    <th style="border: 1px solid #dddddd;">Count</th>
                    <th style="border: 1px solid #dddddd;">AVE</th>
                </tr>
            `;

            let totalCount = 0;
            let totalAve = 0;
            let aveCount = 0;

            data.forEach(client => {
                const row = document.createElement('tr');
                row.style.border = '1px solid #dddddd; padding: 3px;';
                const aveValue = client.ave !== undefined && client.ave !== null && client.ave !== '' ? client.ave : 0;
                row.innerHTML = `
                    <td style="border: 1px solid #dddddd; padding: 3px;">${client.label}</td>
                    <td style="border: 1px solid #dddddd; padding: 3px;">${client.count}</td>
                    <td style="border: 1px solid #dddddd; padding: 3px;">${aveValue}</td>
                `;
                table.appendChild(row);

                totalCount += parseInt(client.count, 10);
                totalAve += parseFloat(aveValue);
                aveCount += aveValue ? 1 : 0;
            });

            const avgAve = aveCount > 0 ? (totalAve / aveCount).toFixed(2) : 0;

            const totalRow = document.createElement('tr');
            totalRow.style.border = '1px solid #dddddd; padding: 3px; font-weight: bold;';
            totalRow.innerHTML = `
                <td style="border: 1px solid #dddddd; padding: 3px;">Total</td>
                <td style="border: 1px solid #dddddd; padding: 3px;">${totalCount}</td>
                <td style="border: 1px solid #dddddd; padding: 3px;">${avgAve}</td>
            `;
            table.appendChild(totalRow);

            container.appendChild(table);
        }
        
        function updateChart(timeFrame) {
            let data = [];
            let labels = [];
            var quantityGraphDaily = <?php echo json_encode($get_quantity_compare_data); ?>;

            switch(timeFrame) {
                case 'daily':
                    data = quantityGraphDaily.map(item => item.total || 0);
                    labels = quantityGraphDaily.map(item => item.month_date || '');
                    break;
                case 'weekly':
                    data = quantityGraphDaily.map(item => item.total || 0);
                    labels = quantityGraphDaily.map(item => item.month_date || '');
                    break;
                case 'monthly':
                    data = quantityGraphDaily.map(item => item.total || 0);
                    labels = quantityGraphDaily.map(item => item.month_date || '');
                    break;
                case 'yearly':
                    data = quantityGraphDaily.map(item => item.total || 0);
                    labels = quantityGraphDaily.map(item => item.month_date || '');
                    break;
            }

            areaChart.data.labels = labels;
            areaChart.data.datasets[0].data = data;
            areaChart.update();

            pieChart.data.labels = labels;
            pieChart.data.datasets[0].data = data;
            pieChart.update();

            barChart.data.labels = labels;
            barChart.data.datasets[0].data = data;
            barChart.update();

            lineChart.data.labels = labels;
            lineChart.data.datasets[0].data = data;
            lineChart.update();

            verticalBarChart.data.labels = labels;
            verticalBarChart.data.datasets[0].data = data;
            verticalBarChart.update();

            const clientData = <?php echo json_encode($getClientData); ?>;
            updateClientNewsCount(clientData);
        }

        showChart('lineChart');
        updateChart('daily');
    });

 
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