<?php require 'connectDB.php';
session_start();
$ordersdata = $connection->query("SELECT * FROM orders");

if (!$ordersdata){
    die("Invalid query: " . $connection->error);
}

if($_SESSION["status"] != true)
{
    header("location:login.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="genChart.css">
    <title>Document</title>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(function() {
        generateChart('overall', -1, -1);
    });

    var uniqueYears = [];
    var currentQuarter = -1;
    var currentQuarterMonths = [];
    var currentData;

    function generateChart(chartType, monthType, year) {
        $.ajax({
            url: 'getChartData.php',
            method: 'GET',
            data: { chartType: chartType, monthType: monthType, year: year},
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {
                    var error = document.querySelector(".error");
                    error.style.display = "block";
                    setTimeout(function() {
                        error.style.display = "none";
                    }, 3000);
                    return;
                }
                currentData = data;
                if(uniqueYears.length == 0) {
                    for (var i = 0; i < data.length; i++) {
                        var year = new Date(data[i].ORDER_DATE).getFullYear();
                        if (!uniqueYears.includes(year)) {
                            uniqueYears.push(year);
                        }
                    }
                }
                currentQuarterMonths = [];
                switch(monthType) {
                    case '1st Quarter':
                        currentQuarter = 0;
                        currentQuarterMonths = ['January', 'February', 'March'];
                        break;
                    case '2nd Quarter':
                        currentQuarter = 1;
                        currentQuarterMonths = ['April', 'May', 'June'];
                        break;
                    case '3rd Quarter':
                        currentQuarter = 2;
                        currentQuarterMonths = ['July', 'August', 'September'];
                        break;
                    case '4th Quarter':
                        currentQuarter = 3;
                        currentQuarterMonths = ['October', 'November', 'December'];
                        break;
                }
                updateValues();
                drawChart(data, chartType);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function drawChart(data, chartType) {
        console.log(data[0]);

        var chartData = new google.visualization.DataTable();
        chartData.addColumn('date', 'Date');
        chartData.addColumn('number', 'Order Cost');

        for (var i = 0; i < data.length; i++) {
            var date = new Date(data[i].ORDER_DATE);
            var orderCost = parseFloat(data[i].ORDER_COST);
            chartData.addRow([date, orderCost]);
        }

        var options = {
            title: changeTitle(chartType),
            titleTextStyle: {
                fontSize: 18,
                bold: true,
                textAlign: 'center'
            },
            hAxis: formatter(chartType, data),
            legend: {
                position: 'none'
            },
            vAxis: {
                viewWindow: {
                    min: 0
                }
            },
            enableInteractivity: true
        };

        var chart = new google.visualization.LineChart(document.getElementById('linechart_material'));
        chart.draw(chartData, options);
    }
    
    function changeTitle(chartType) {
        switch(chartType) {
            case 'overall':
                return 'Overall';
                break;
            case 'monthly':
                return 'Monthly';
                break;
            case 'yearly':
                return 'Yearly';
                break;
            case 'quarter':
                return 'Quarter';
                break;
        }
    }

    function formatter(chartType, data) {
        var curMonth =  new Date(data[0].ORDER_DATE).getMonth();
        var months = 12;
        var year = new Date(data[0].ORDER_DATE).getFullYear();
        var maxDays = new Date(year, curMonth, 0).getDate();

        switch(chartType) {
            case 'overall':
                var firstYear = uniqueYears[0];
                var lastYear = uniqueYears[uniqueYears.length - 1];
                var yearGridlines = lastYear - firstYear + 1;
                return {
                    format: 'yyyy',
                    gridlines: {
                        count: lastYear - firstYear + 1
                    },
                    ticks: (function() {
                        var ticks = [];
                        var i = 0;
                        for(var i = firstYear; i <=  lastYear + 1; i++) {
                            ticks.push(new Date(i, 0, 1));
                        }
                        return ticks;
                    })(),
                    slantedText: true,
                    slantedTextAngle: 45
                };
                break;
            case 'monthly':
                return {
                    format: 'yyyy-MM-dd',
                    gridlines: {
                        count: maxDays
                    },
                    ticks: (function() {
                        var ticks = [];
                        var i = 0;
                        while (i < Math.floor(maxDays/ 5)) {
                            ticks.push(new Date(year, curMonth, 5 * i + 1));
                            i++;
                        }
                        return ticks;
                    })(),
                    slantedText: true,
                    slantedTextAngle: 45
                };
                break;
            case 'yearly':
                return {
                    format: 'MMM',
                    gridlines: {
                        count: months
                    },
                    ticks: (function() {
                        var ticks = [];
                        var i = 0;
                        while (i < months) {
                            ticks.push(new Date(year, i, 1));
                            i++;
                        }
                        return ticks;
                    })(),
                    slantedText: true,
                    slantedTextAngle: 45
                };
                break;
            case 'quarter':
                return {
                    format: 'MMM',
                    gridlines: {
                        count: currentQuarterMonths.length
                    },
                    ticks: (function() {
                        var ticks = [];
                        var i = 0;
                        while (i < currentQuarterMonths.length) {
                            ticks.push(new Date(year, i + 3*currentQuarter, 1));
                            i++;
                        }
                        return ticks;
                    })(),
                    slantedText: true,
                    slantedTextAngle: 45
                };
        }
    }
    
    </script>
</head>
<body>
<nav class="site-nav grid"> 
    <a id="backButton"><img src="assets/img/Back.png" alt=""></a>
    <p>Generate Chart</p>
</nav>

<p class="error">There is no data in the selected range</p>

<form  method="post" enctype="multipart/form-data">
    <div class="forms">
    
    <div class="chart">
        <div id = "linechart_material" style="z-index: 0"></div>
    </div>

    <div class="generate-form">
        <button type="button" class="gen-button" onclick="generateChart('overall', -1, -1); updateValues();"><p>Overall</p></button>
        <button id="monthlyButton" type="button" class="gen-button"><p>Monthly</p></button>
        <button id="yearlyButton" type="button" class="gen-button"><p>Yearly</p></button>
        <button id="quarterButton" type="button" class="gen-button"><p>Quarter</p></button>
    </div>
    
    <div class="create-form">
        <p>Overall Date Range</p>
        <p id="dateRange"></p>

    </div>
    <div class="create-form">
        <p>Average Order Cost</p>
        <p id="averageOrderCost"></p>
    </div>
    <div class="create-form">
        <p>Highest Sale</p>
        <p id="highestSale"></p>
    </div>

    <div class="create-form">
        <p>Lowest Sale</p>
        <p id="lowestSale"></p>
    </div>

    </div>
    

    
</form>
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="selectionOptions">
            <p>Select Year:</p>
            <div id="yearOptions">
            </div>
        </div>
    </div>
</div>



    <script> 
    var urlParams = new URLSearchParams(window.location.search);
    var referrer = urlParams.get('referrer');
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    // Set the back button link to the referring page URL
    if (referrer) {
        document.getElementById("backButton").href = referrer;
    } else {
        // Set a default back button link if no referring page is provided
        document.getElementById("backButton").href = "index.php";
    }

    var modal = document.getElementById("myModal");
    var resetModal = "<p>Select Year:</p> \n<div id=\"yearOptions\"></div>";

    var btn = document.getElementById("monthlyButton");
    var btn1 = document.getElementById("yearlyButton");
    var btn2 = document.getElementById("quarterButton");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
        displayYears(0);
        document.body.style.overflow = "hidden";
    }

    btn1.onclick = function() {
        modal.style.display = "block";
        displayYears(1);
        document.body.style.overflow = "hidden";
    }

    btn2.onclick = function() {
        modal.style.display = "block";
        displayYears(2);
        document.body.style.overflow = "hidden";
    }

    span.onclick = function() {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
        document.getElementById("selectionOptions").innerHTML = resetModal;
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
            document.getElementById("selectionOptions").innerHTML = resetModal;
        }
    }

    function displayYears(btnType) {

        var yearOptions = document.getElementById("yearOptions");
        yearOptions.innerHTML = ""; 

        for (var i = 0; i < uniqueYears.length; i++) {
            var button = document.createElement("button");
            button.textContent = uniqueYears[i];
            button.onclick = function() {
                var selectedYear = this.textContent;
                if(btnType == 0) {
                    displayMonths(selectedYear);
                }
                else if (btnType == 1) {
                    generateChart('yearly', -1, selectedYear);
                    modal.style.display = "none";
                    document.body.style.overflow = "auto";
                }
                else if (btnType == 2) {
                    displayQuarter(selectedYear);
                }
            };
            yearOptions.appendChild(button);
        }
    }

    function displayMonths(year) {
        var selectionOptions = document.getElementById("selectionOptions");
        selectionOptions.innerHTML = "<p>Select Month:</p>";
        
        var selectedMonthIndex = -1;
        
        var monthOptions = document.createElement("div");
        monthOptions.style.display = "flex";
        monthOptions.style.justifyContent = "center";
        monthOptions.style.flexWrap = "wrap";
        
        for (var i = 0; i < 12; i++) {
            var button = document.createElement("button");
            button.style.height = "50px";
            button.style.width = "60%";
            button.style.margin = "auto auto";
            button.style.marginTop = "7.5%";
            button.style.borderRadius = "20px";
            button.textContent = monthNames[i];
            button.onclick = function() {
                var selectedMonth = this.textContent;
                generateChart('monthly', selectedMonth, year);
                modal.style.display = "none";
                document.body.style.overflow = "auto";
                selectionOptions.innerHTML = resetModal;
            };
            monthOptions.appendChild(button);
        }
        
        selectionOptions.appendChild(monthOptions);
    }

    function displayQuarter(year) {
        var selectionOptions = document.getElementById("selectionOptions");
        selectionOptions.innerHTML = "<p>Select Quarter:</p>";
        
        var quarterNames = ["1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"];
        
        var quarterOptions = document.createElement("div");
        quarterOptions.style.display = "flex";
        quarterOptions.style.justifyContent = "center";
        quarterOptions.style.flexWrap = "wrap";
        
        for (var i = 0; i < 4; i++) {
            var button = document.createElement("button");
            button.style.height = "50px";
            button.style.width = "60%";
            button.style.margin = "auto auto";
            button.style.marginTop = "7.5%";
            button.style.borderRadius = "20px";
            button.textContent = quarterNames[i];
            button.onclick = function() {
                var selectedQuarter = this.textContent;
                generateChart('quarter', selectedQuarter, year);
                modal.style.display = "none";
                document.body.style.overflow = "auto";
                selectionOptions.innerHTML = resetModal;
            };
            quarterOptions.appendChild(button);
        }
        
        selectionOptions.appendChild(quarterOptions);
    }

    function updateValues() {
        var dateRange = document.getElementById("dateRange");
        var averageOrderCost = document.getElementById("averageOrderCost");
        var highestSale = document.getElementById("highestSale");
        var lowestSale = document.getElementById("lowestSale");

        var firstDate = formatDate(new Date(currentData[0].ORDER_DATE));
        var lastDate = formatDate(new Date(currentData[currentData.length - 1].ORDER_DATE));
        var rangeString = firstDate + " - " + lastDate;
        dateRange.textContent = rangeString;

        var divisor = 0;
        var average = 0;
        var highestSaleValue = 0;
        var lowestSaleValue = Infinity;
        for(var i = 0; i < currentData.length; i++) {
            currentSale = parseFloat(currentData[i].ORDER_COST);
            average += currentSale;
            divisor = i + 1;
            if(currentSale > highestSaleValue) {
                highestSaleValue = currentSale;
            }
            if (currentSale < lowestSaleValue) {
                lowestSaleValue = currentSale;
            }
        }
        average = average / divisor;
        averageOrderCost.textContent = "₱" + average.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        highestSale.textContent = "₱" + highestSaleValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        lowestSale.textContent = "₱" + lowestSaleValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatDate(date) {
        var year = date.getFullYear();
        var month = monthNames[date.getMonth()];
        var day = date.getDate();
        return month + " " + day + ", " + year;
    }
    </script>
</body>

</html>