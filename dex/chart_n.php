<?php 
session_start();

include('../__glob.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=htmlspecialchars($_GET['coin'])?></title>

		<style type="text/css">
			.highcharts-credits {
				display: none!important;
			}
		</style>
	</head>
	<body>
<script src="/jquery.min.js"></script>
<script src="Highstock/code/highstock.js"></script>
<script src="Highstock/code/modules/drag-panes.js"></script>
<script src="Highstock/code/modules/exporting.js"></script>


<div id="container" style="height: 580px; min-width: 310px"></div>


		<script type="text/javascript">

$.getJSON('https://monsternode.net/dex/chart_data.php?coin=<?=htmlspecialchars($_GET['coin'])?>', function (data) {

    // split the data set into ohlc and volume
    var ohlc = [],
        volume = [],
        dataLength = data.length,
        // set the allowed units for data grouping
        groupingUnits = [[
    'millisecond', // unit name
    [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
], [
    'second',
    [1, 2, 5, 10, 15, 30]
], [
    'minute',
    [1, 2, 5, 10, 15, 30]
], [
    'hour',
    [1, 2, 3, 4, 6, 8, 12]
], [
    'day',
    [1]
], [
    'week',
    [1]
], [
    'month',
    [1, 3, 6]
], [
    'year',
    null
]],

        i = 0;

    for (i; i < dataLength; i += 1) {
        ohlc.push([
            data[i][0], // the date
            data[i][1], // open
            data[i][2], // high
            data[i][3], // low
            data[i][4] // close
        ]);

        volume.push([
            data[i][0], // the date
            data[i][5] // the volume
        ]);
    }


    // create the chart
    Highcharts.stockChart('container', {

        rangeSelector: {

            buttons: [{
                type: 'hour',
                count: 3,
                text: '3h'
            }, {
                type: 'day',
                count: 1,
                text: '24h'
            }, {
                type: 'day',
                count: 3,
                text: '3d'
            }, {
                type: 'week',
                count: 1,
                text: '1w'
            }, {
                type: 'month',
                count: 1,
                text: '1m'
            }, {
                type: 'month',
                count: 6,
                text: '6m'
            }, {
                type: 'year',
                count: 1,
                text: '1y'
            }, {
                type: 'all',
                text: 'All'
            }],
            selected: 2
        },

        title: {
            text: '<?=htmlspecialchars($_GET['coin'])?>'
        },

        yAxis: [{
            labels: {
                align: 'right',
                x: -3
            },
            title: {
                text: 'Price, <?=$GLOBALS['minter_base_coin']?>'
            },
            height: '60%',
            lineWidth: 2,
            resize: {
                enabled: true
            }
        }, {
            labels: {
                align: 'right',
                x: -3
            },
            title: {
                text: 'Volume'
            },
            top: '65%',
            height: '35%',
            offset: 0,
            lineWidth: 2
        }],

        tooltip: {
            split: true
        },
        series: [{
        	type: 'candlestick',
            name: 'Price',
            marker: {
                enabled: true,
                radius: 2
            },
            shadow: true,
            color:'#d01b1b',
            lineColor:"#ссс",
            upColor:"#008c0a",
            data: ohlc,
            dataGrouping: {
                units: groupingUnits
            }
        },
        {
            type: 'column',
            name: 'Volume',
            data: volume,
            color:'#666666',
            yAxis: 1,
            dataGrouping: {
                units: groupingUnits
            }
        }]
    });
});
		</script>
	</body>
</html>
