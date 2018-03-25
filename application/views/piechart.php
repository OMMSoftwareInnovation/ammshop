<html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load the Visualization API and the line package.
            google.charts.load('current', {'packages':['corechart']});
            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);
             
            function drawChart() {
              $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>Admin/getdata',
                success: function (data1) {
                    var data = new google.visualization.DataTable();
                    // Add legends with data type
                    data.addColumn('string', 'Year');
                   data.addColumn('number', 'Sales');
                   //Parse data into Json
                   var jsonData = $.parseJSON(data1);
                   for (var i = 0; i < jsonData.length; i++) {
                     data.addRow([jsonData[i].year, parseInt(jsonData[i].sales)]);
                   }
                    
                   var options = {
                    legend: '',
                    pieSliceText: 'label',
                    title: 'Company Sales Performance',
                  };
    
                  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                  chart.draw(data, options);
                 }
              });
            }
        </script>
     </head>
   
     <body>
     <section class="content">
        <div class="container-fluid">           
        <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
       
    </section>
     </body>

