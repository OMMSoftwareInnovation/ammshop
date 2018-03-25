<html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
      // Load the Visualization API and the line package.
      google.charts.load('current', {'packages':['line']});
      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
  
    function drawChart() {
  
        $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Admin/getdata',
          
        success: function (data1) {
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable();
  
      data.addColumn('string', 'Year');
      data.addColumn('number', 'Sales');
      data.addColumn('number', 'Expense');
        
      var jsonData = $.parseJSON(data1);
      
      for (var i = 0; i < jsonData.length; i++) {
            data.addRow([jsonData[i].year, parseInt(jsonData[i].sales), parseInt(jsonData[i].expense)]);
      }
      var options = {
        chart: {
          title: 'Company Performance',
          subtitle: 'Show Sales and Expense of Company'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'bottom'} 
          }
        }
         
      };
      var chart = new google.charts.Line(document.getElementById('line_chart'));
      chart.draw(data, options);
       }
     });
    }
  </script>
</head>   
     <body>
     <section class="content">
        <div class="container-fluid">           
        <div id="line_chart"></div>
        </div>
    </section>
     </body>

