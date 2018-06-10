function loadChart() { $(function(){
	$.ajax({
    		url: 'https://turing.bowdoin.edu/~dparsons/chart_data.php',
    		type: 'GET',
    		success : function(data) {
    			chartData = data;
			dataSize = chartData.length;
			// caption should include device name -- take from data
			if (chartData.length > 0) {
				var label = chartData[0]['name_label'];
				
			} else {
				var label = "";
			}
			var caption = "Energy Usage for";
			caption = caption.concat(label);
      			var chartProperties = {
        			"caption": "Energy Usage for ".concat(label),
        			"xAxisName": "Date",
        			"yAxisName": "Energy Output (Watts)",
        			"rotatevalues": "1",
        			"theme": "zune",
				"showValues": "0",
				"drawAnchors": "0",
				"anchorRadius": "1",
				"showshadow": "0",
				"labelStep": dataSize / 8,
				"animation": "0"
      			};
        		apiChart = new FusionCharts({
        			type: 'line',
        			renderAt: 'chart-container',
        			width: '550',
        			height: '350',
        			dataFormat: 'json',
        			dataSource: {
        	  			"chart": chartProperties,
        	  			"data": chartData
        			}
      			});
      			apiChart.render();
    		}
  	});
});
//setTimeout(loadChart, 1000);
}

loadChart();
