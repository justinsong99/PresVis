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
  $year = $_POST['year'];

  $result = $con->query("SELECT candidate, candidatevotes as Votes FROM PresHistory WHERE state = '$state' AND year = '$year'");
      if (!$result) {
        echo "Query failed!\n";
      }
  // PHP code about to end
  ?>
  <!DOCTYPE html>
    <html>
    <head>
        <title>Visualzing Presidential Data in <?php echo $state ?>  In <?php echo $year ?></title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});

            google.charts.setOnLoadCallback(drawChart);
            function drawChart(){
                var data = new google.visualization.DataTable();
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Votes'],
                    <?php
                        while($row = $result->fetch_assoc()){
                            echo "['".$row["candidate"]."', ".$row["Votes"]."],";
                        }
                    ?>
                   ]);

                var options = {
                    legend: { position: 'bottom' },
                    vAxis: {title: 'Votes'},
                    hAxis: {title: 'Candidate'}
                };

                var chart = new google.visualization.BarChart(document.getElementById('vcChart'));
                chart.draw(data, options);
            }

        </script>
    </head>
    <body>
          <h3> Visualizing Presidential Data in <?php echo $state ?>  In <?php echo $year ?></h3>
         <div id="vcChart" style="width: 900px; height: 400px"></div>
    </body>
    </html>
