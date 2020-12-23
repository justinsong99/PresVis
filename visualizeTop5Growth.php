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

    $result = $con->query("select Year, Top_5Percent as Top_5_Percent FROM IncomeDist");

      if (!$result) {
        echo "Query failed!\n";
      }
  // PHP code about to end
  ?>
  <!DOCTYPE html>
    <html>
    <head>
        <title>How the Top 5 Percent's Share of Household Income has Changed Over Time</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});

            google.charts.setOnLoadCallback(drawChart);
            function drawChart(){
                var data = new google.visualization.DataTable();
                var data = google.visualization.arrayToDataTable([
                    ['Year','Share of Household Income'],
                    <?php
                        while($row = $result->fetch_assoc()){
                            echo "['".$row["Year"]."', ".$row["Top_5_Percent"]."],";
                        }
                    ?>
                   ]);

                var options = {
                    title: 'Top 5 Percent of Household\'s Income Share',
                    curveType:'function' ,
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('incomechart'));
                chart.draw(data, options);
            }

        </script>
    </head>
    <body>
         <div id="incomechart" style="width: 900px; height: 400px"></div>
    </body>
    </html>
