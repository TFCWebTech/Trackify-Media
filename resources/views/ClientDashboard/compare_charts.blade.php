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
            <div class="size">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6 class="text-primary">Overview / Size</h6>
                    </div>
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
                    <button class="btn btn-primary" onclick="showChart2('sizebarChart')">Bar Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizelineChart')">Line Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('sizeverticalBarChart')">Column Chart</button>
                    <button class="btn btn-primary" onclick="showChart2('showSizeTableData')">Table Data</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let areaChart = initializeChart('myAreaChart', 'line');
    let pieChart = initializeChart('myPieChart', 'doughnut');
    let barChart = initializeChart('myBarChart', 'bar');
    let lineChart = initializeChart('myLineChart', 'line');
    let verticalBarChart = initializeChart('myVerticalBarChart', 'bar');

    let sizeBarChart = initializeChart('sizeBarChart', 'bar');
    let sizeLineChart = initializeChart('sizeLineChart', 'line');
    let sizeVerticalBarChart = initializeChart('sizeVerticalBarChart', 'bar');

    let mediaBarChart = initializeChart('mediaBarChart', 'bar');
    let mediaLineChart = initializeChart('mediaLineChart', 'line');
    let mediaVerticalBarChart = initializeChart('mediaVerticalBarChart', 'bar');
    
    let publicationBarChart = initializeChart('publicationBarChart', 'bar');
    let publicationLineChart = initializeChart('publicationLineChart', 'line');
    let publicationVerticalBarChart = initializeChart('publicationVerticalBarChart', 'bar');

    let geographyBarChart = initializeChart('geographyBarChart', 'bar');
    let geographyLineChart = initializeChart('geographyLineChart', 'line');
    let geographyVerticalBarChart = initializeChart('geographyVerticalBarChart', 'bar');

    let journalistBarChart = initializeChart('journalistBarChart', 'bar');
    let journalistLineChart = initializeChart('journalistLineChart', 'line');
    let journalistVerticalBarChart = initializeChart('journalistVerticalBarChart', 'bar');


    let avePieChart = initializeChart('avePieChart', 'pie');
    let aveBarChart = initializeChart('aveBarChart', 'bar');
    let aveLineChart = initializeChart('aveLineChart', 'line');
    let aveVerticalBarChart = initializeChart('aveVerticalBarChart', 'bar');
   
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
                    updatePublicationCharts(response.publication_data);
                    updateGeographyCharts(response.geography_data);
                    updateJournalistCharts(response.journalist_data);
                    updateSizeCharts(response.size_data);
                    updateAveCharts(response.ave_data);
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
    function updateSizeCharts(news_data) 
    {
    let sizeLabels = [];
    let lineDataset = [];
    let barDataset = [];
    let columnDataset = [];
    let category = new Set();

    // Process the news_data array
    news_data.forEach(item => {
        sizeLabels.push(item.label);

        // Add categories to the set
        category.add(item.category);
    });

    // Create final data structure
    let finalData = Array.from(category).map(cat => {
        let counts = [];
        let labels = [];

        sizeLabels.forEach(label => {
            let dataItem = news_data.find(news => news.label === label && news.category === cat);
            counts.push(dataItem ? dataItem.count || 0 : 0);
            labels.push(dataItem ? dataItem.label : '');
        });

        return {
            label: cat,
            count: counts,
            labels: labels
        };
    });

    // Update datasets for chart types
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

    // Update the charts with the new datasets
    updateChart(sizeBarChart, sizeLabels, barDataset);
    updateChart(sizeLineChart, sizeLabels, lineDataset);
    updateChart(sizeVerticalBarChart, sizeLabels, columnDataset);
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
    function updateAveCharts(news_data) {
    let AveLabels = [];
    let lineDataset = [];
    let barDataset = [];
    let columnDataset = [];
    let aveSet = new Set();

    // Process the news_data array
    news_data.forEach(item => {
        // Collect unique labels
        if (!AveLabels.includes(item.label)) {
            AveLabels.push(item.label);
        }

        // Collect unique ave values
        aveSet.add(item.ave);
    });

    // Create final data structure
    let finalData = Array.from(aveSet).map(ave => {
        let counts = [];
        let labels = [];

        AveLabels.forEach(label => {
            // Find data items that match both the label and ave
            let dataItem = news_data.find(news => news.label === label && news.ave === ave);
            counts.push(dataItem ? dataItem.count || 0 : 0);
            labels.push(dataItem ? dataItem.label : '');
        });

        return {
            label: `AVE ${ave}`,  // Prefix label with 'AVE' for clarity
            count: counts
        };
    });

    // Update datasets for chart types
    finalData.forEach(dataItem => {
        let color = getRandomColor(0.1);
        
        // Line Chart Dataset
        lineDataset.push({
            label: dataItem.label,
            data: dataItem.count,
            backgroundColor: color.background,
            borderColor: color.border,
            borderWidth: 2,
            fill: true
        });

        // Bar Chart Dataset
        barDataset.push({
            label: dataItem.label,
            data: dataItem.count,
            backgroundColor: color.background,
            borderColor: color.border,
            borderWidth: 1
        });

        // Column Chart Dataset
        columnDataset.push({
            label: dataItem.label,
            data: dataItem.count,
            backgroundColor: color.background,
            borderColor: color.border,
            borderWidth: 1
        });
    });

    // Update the charts with the new datasets
    updateChart(avePieChart, AveLabels, lineDataset); // Ensure 'line' is correct for pie chart
    updateChart(aveBarChart, AveLabels, barDataset); // Update bar chart
    updateChart(aveLineChart, AveLabels, lineDataset); // Update line chart
    updateChart(aveVerticalBarChart, AveLabels, columnDataset); // Update vertical bar chart
}
    function updatePublicationCharts(news_data) {
        let publicationLabels = [];
        let lineDataset = [];
        let barDataset = [];
        let columnDataset = [];
        let clientNames = new Set();

        for (let publication in news_data) {
            if (news_data.hasOwnProperty(publication)) {
                publicationLabels.push(publication);

                news_data[publication].forEach(news => clientNames.add(news.Client_name));
            }
        }

        let finalData = Array.from(clientNames).map(clientName => {
            let counts = [];
            for (let publication in news_data) {
                let publicationData = news_data[publication];
                let countData = publicationData.find(news => news.Client_name === clientName);
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

        updateChart(publicationBarChart, publicationLabels, barDataset);
        updateChart(publicationLineChart, publicationLabels, lineDataset);
        updateChart(publicationVerticalBarChart, publicationLabels, columnDataset);
    }
    
    function updateGeographyCharts(news_data) {
        let GeographyLabels = [];
        let lineDataset = [];
        let barDataset = [];
        let columnDataset = [];
        let clientNames = new Set();

        for (let geography in news_data) {
            if (news_data.hasOwnProperty(geography)) {
                GeographyLabels.push(geography);

                news_data[geography].forEach(news => clientNames.add(news.Client_name));
            }
        }

        let finalData = Array.from(clientNames).map(clientName => {
            let counts = [];
            for (let geography in news_data) {
                let geographyData = news_data[geography];
                let countData = geographyData.find(news => news.Client_name === clientName);
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

        updateChart(geographyBarChart, GeographyLabels, barDataset);
        updateChart(geographyLineChart, GeographyLabels, lineDataset);
        updateChart(geographyVerticalBarChart, GeographyLabels, columnDataset);
    }

    function updateJournalistCharts(news_data) {
        let JournalistLabels = [];
        let lineDataset = [];
        let barDataset = [];
        let columnDataset = [];
        let clientNames = new Set();

        for (let Journalist in news_data) {
            if (news_data.hasOwnProperty(Journalist)) {
                JournalistLabels.push(Journalist);

                news_data[Journalist].forEach(news => clientNames.add(news.Client_name));
            }
        }

        let finalData = Array.from(clientNames).map(clientName => {
            let counts = [];
            for (let Journalist in news_data) {
                let JournalistData = news_data[Journalist];
                let countData = JournalistData.find(news => news.Client_name === clientName);
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

        updateChart(journalistBarChart, JournalistLabels, barDataset);
        updateChart(journalistLineChart, JournalistLabels, lineDataset);
        updateChart(journalistVerticalBarChart, JournalistLabels, columnDataset);
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
    window.showChart2 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-2');
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

    window.showChart4 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-4');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }

    window.showChart5 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-5');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }
    window.showChart6 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-6');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }
    window.showChart7 = function(chartId) {
        const charts = document.querySelectorAll('.chart-container-7');
        charts.forEach(chart => {
            chart.classList.remove('active');
        });
        document.getElementById(chartId).classList.add('active');
    }
    window.handleChartTypeChange = function() {
        const selectedValue = document.getElementById('chartTypeSelector').value;
        const quantityCharts = document.querySelector('.quantity');
        const sizeCharts = document.querySelector('.size');
        const mediaCharts = document.querySelector('.media');
        const publicationCharts = document.querySelector('.publication');
        const geographyCharts = document.querySelector('.geography');
        const journalistCharts = document.querySelector('.journalist');
        const aveCharts = document.querySelector('.ave');
        quantityCharts.style.display = selectedValue === 'Quantity' ? 'block' : 'none';
        sizeCharts.style.display = selectedValue === 'Size' ? 'block' : 'none';
        mediaCharts.style.display = selectedValue === 'Media' ? 'block' : 'none';
        publicationCharts.style.display = selectedValue === 'Publication' ? 'block' : 'none';
        geographyCharts.style.display = selectedValue === 'Geography' ? 'block' : 'none';
        journalistCharts.style.display = selectedValue === 'Journalist' ? 'block' : 'none';
        aveCharts.style.display = selectedValue === 'ave' ? 'block' : 'none';
        
    }

    showChart('lineChart');
    showChart2('sizelineChart');
    showChart3('medialineChart');
    showChart4('publicationlineChart');
    showChart5('geographylineChart');
    showChart6('journalistlineChart');
    showChart7('aveLineChart');
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