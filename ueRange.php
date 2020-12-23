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

  // ********* Remember to use your MySQL username and password here ********* //

  if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }

    $date_1 = $_POST['date1'];
    $date_2 = $_POST['date2'];

    $minYear = "1949";
    $maxYear = "2019";
    // This says that the $ID variable should be assigned a value obtained as an
    // input to the PHP code. In this case, the input is called 'ID'.
    if(!isset($date_1) || trim($date_1) == ''){
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if (!isset($date_2) || trim($date_2) == '') {
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if ($date_1 < $minYear || $date_2 > $maxYear) {
      echo "ERROR: UE data only available for 1949-2019";
    }
    else {

    $result = $con->query("SELECT * FROM unemployment WHERE Year>='$date_1' AND Year <='$date_2'");
      // a simple query on the Rawscores table
      if (!$result) {
        echo "Query failed!\n";
      } else {

        //if ($result = $db->store_result()) {
          $field = $result->fetch_fields();
          foreach($field as $val){
            $columns[] = $val->name;
          }
          if (strcmp($columns[0], "ERROR") == 0) {
            $rowtemp = $result->fetch_row();
            echo "<table border=1>\n";
            echo "<tr><td>ERROR</td></tr>\n";
            printf("<tr><td>%s</td></tr>\n", $rowtemp[0]);
            echo "</table>\n";
          } else {
            echo "<table border=1>\n";
            echo "<tr><td>Year</td><td>Rate</td></tr>\n";
            while ($row = $result->fetch_row()) {
              printf("<tr><td>%s</td><td>%s</td></tr>\n", $row[0], $row[1]);
            }
            echo "</table>\n<br /><br />";
          }

      //  }
      $result = $con->query("SELECT * FROM unemployment WHERE Year>='$date_1' AND Year <='$date_2'");
      }
    }
  // PHP code about to end
  ?>

<!DOCTYPE html>
  <html>
  <head>
      <title>Unemployment History</title>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});

          google.charts.setOnLoadCallback(drawChart);
          function drawChart(){
              var data = new google.visualization.DataTable();
              var data = google.visualization.arrayToDataTable([
                  ['Year','UERate'],
                  <?php
                      while($row = $result->fetch_assoc()){
                          echo "['".$row["Year"]."', ".$row["UERate"]."],";
                      }
                  ?>
                 ]);

              var options = {
                  title: 'History of the Unemployment Rate',
                  legend: { position: 'bottom' }
              };

              var chart = new google.visualization.BarChart(document.getElementById('uechart'));
              chart.draw(data, options);
          }

      </script>
  </head>
  <body>
       <div id="uechart" style="width: 900px; height: 400px"></div>
  </body>
  </html>
