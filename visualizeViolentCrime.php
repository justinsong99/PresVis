<?php
  // PHP code just started

  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', true);
  // display errors
  $dbhost = 'dbase.cs.jhu.edu';
  $dbuser = '20fa_jsong69';
  $dbpass = 'Jv6g8ON4Pg';
  $dbname = '20fa_jsong69_db';
  $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  if ($con->connect_error) {

    die("Connection failed!");

  }

  $state = $_POST['state'];

  $result = $con->query("SELECT year as Year, violent_crime/population as ViolentCrimePerCapita FROM Crime WHERE state_name = '$state'");
      if (!$result) {
        echo "Query failed!\n";
      }
  // PHP code about to end
  ?>
  <!DOCTYPE html>
    <html>
    <head>
        <title>Visualzing Violent Crime in <?php echo $state ?>  Since 1979</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});

            google.charts.setOnLoadCallback(drawChart);
            function drawChart(){
                var data = new google.visualization.DataTable();
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Violent Crime'],
                    <?php
                        while($row = $result->fetch_assoc()){
                            echo "['".$row["Year"]."', ".$row["ViolentCrimePerCapita"]."],";
                        }
                    ?>
                   ]);

                var options = {
                    curveType:'function' ,
                    legend: { position: 'bottom' },
                    vAxis: {title: 'Violent Crime Rate Per Capita'},
                    hAxis: {title: 'Year'}
                };

                var chart = new google.visualization.LineChart(document.getElementById('vcChart'));
                chart.draw(data, options);
            }

        </script>
    </head>
    <body>
          <h3> Violent Crime in <?php echo $state ?> since 1979</h3>
         <div id="vcChart" style="width: 900px; height: 400px"></div>
    </body>
    </html>
