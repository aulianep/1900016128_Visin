<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
        //load form CI Controller
        var PieChartData='<?php echo $PieChartData;?> '

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(JSON.parse(PieChartData));

        // Set chart options
        var options = {'title':'<?php echo $PieChartTitle; ?>',
                       'width':0,
                       'height':0};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        //line chart
        var LineChartData='<?php echo $LineChartData;?> '
        var line_data = google.visualization.arrayToDataTable(JSON.parse(LineChartData));

        var line_options = {
          title: '<?php echo $LineChartTitle;?> ',
          // curveType: 'function',
          legend: { position: 'bottom' }
        };

        var line_chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        line_chart.draw(line_data, line_options);

        //bar chart
        var BarChartData='<?php echo $BarChartData;?> '
        var bar_data = google.visualization.arrayToDataTable(JSON.parse(BarChartData));
        
        var bar_options = {
          title: '<?php echo $BarChartTitle;?> ',
          legend: { position: 'bottom' },
          hAxis: {
            title: 'Jenis Ayam',
          },
          vAxis: {
            title: ''
          }
        };

        var bar_chart = new google.visualization.ColumnChart(
          document.getElementById('bar_chart'));

        bar_chart.draw(bar_data, bar_options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
    <div id="curve_chart"></div>
    <div id="bar_chart"></div>
  </body>
</html>