function grid_line_chart(domId, jsonData)
{
    var json = JSON.parse(jsonData);

    var labels_arr = new Array();
    var data_arr = new Array();
    
    $.each(json, function (index, value) {
        labels_arr.push(index);
        data_arr.push(value['total_cnt']);
    });
    //console.log(data_arr);

    var chart_ctx = document.getElementById(domId).getContext('2d');

    var myLineChart = new Chart(chart_ctx, {
        type: 'line',
        data: {
            labels: labels_arr,
            datasets: [{
                label: "Active Users",
                borderColor: "#1d7af3",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#1d7af3",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: data_arr
            }]
        },
        options : {
            responsive: true, 
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels : {
                    padding: 10,
                    fontColor: '#1d7af3',
                }
            },
            tooltips: {
                bodySpacing: 4,
                mode:"nearest",
                intersect: 0,
                position:"nearest",
                xPadding:10,
                yPadding:10,
                caretPadding:10
            },
            layout:{
                padding:{left:15,right:15,top:15,bottom:15}
            }
        }
    });
}

function grid_bar_chart(domId, jsonData, maxVal)
{
    var json = JSON.parse(jsonData);

    var labels_arr = new Array();
    var data_arr = new Array();
    
    $.each(json, function (index, value) {
        labels_arr.push(index + '시');
        data_arr.push(value['total_cnt']);
    });

    Chart.pluginService.register({
        beforeDraw: function (chart, easing) {
            if (chart.config.options.chartArea && chart.config.options.chartArea.backgroundColor) {
                var helpers = Chart.helpers;
                var ctx = chart.chart.ctx;
                var chartArea = chart.chartArea;

                ctx.save();
                ctx.fillStyle = chart.config.options.chartArea.backgroundColor;
                ctx.fillRect(chartArea.left, chartArea.top, chartArea.right - chartArea.left, chartArea.bottom - chartArea.top);
                ctx.restore();
            }
        }
    });
    
    var config = {
        type: 'bar',
        data: {
            labels: labels_arr,
            borderColor : "#fffff",
            datasets: [{
                data: data_arr,
                backgroundColor: '#89E80D',
                borderColor : "#fff",
            }],
        },
        options: {
            responsive:false,
            legend: { display: false },
            chartArea: { backgroundColor: 'rgba(149,175,214,0.1)' },
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks:{
                        fontColor: "#9B9DA7",
                        min: 0,
                        max: parseInt(maxVal),
                    },
                    gridLines:{
                        color: '#646C81',
                        zeroLineColor :"#646C81",
                    },
                }],
                xAxes: [{
                    ticks:{
                        fontColor: "#9B9DA7",
                    },
                    gridLines:{
                        drawBorder: false,
                        color: '#646C81'
                    }
                }]
            },
        }
    };
    
    var ctx = document.getElementById(domId).getContext('2d');
    new Chart(ctx, config);
}