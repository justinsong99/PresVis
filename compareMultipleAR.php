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
$pres1 = 'none';
$pres2 = 'none';

if ($con->connect_error) {
  die("Connection failed!");
}
if (count($_POST)<2 || count($_POST)>2) {
  die("Must select exactly 2 Presidents to compare!");
}

  if (!isset($_POST['BillClinton'])) {
    //No 42
    if (!isset($_POST['GeorgeWBush'])) {
      //No 43
      //so its just 44 and 45
      $pres1 = 'Obama';
      $pres2 = 'Trump';
      $result = $con->query("SELECT derived.DayNumber, derived.44Approve as app1, derived2.45Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 44Approve FROM 44ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 45Approve FROM 45ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");
    }
    else {
      //43 in
      if (!isset($_POST['BarackObama'])) {
        //no 44
        //43 and 45
        $pres1 = 'Bush 43';
        $pres2 = 'Trump';
        $result = $con->query("SELECT derived.DayNumber, derived.43Approve as app1, derived2.45Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 43Approve FROM 43ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 45Approve FROM 45ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");

      }
      else {
        //43 and 44
        $pres1 = 'Bush 43';
        $pres2 = 'Obama';
        $result = $con->query("SELECT derived.DayNumber, derived.43Approve as app1, derived2.44Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 43Approve FROM 43ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 44Approve FROM 44ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");

      }
    }

  }
  else {
    // 42 in
    if (!isset($_POST['GeorgeWBush'])) {
      //no 43
      if (!isset($_POST['BarackObama'])) {
        //no 44
        //42 and 45
        $pres1='Clinton';
        $pres2='Trump';
        $result = $con->query("SELECT derived.DayNumber, derived.42Approve as app1, derived2.45Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 42Approve FROM 42ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 45Approve FROM 45ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");

      }
      else {
        //42 and 44
        $pres1='Clinton';
        $pres2='Obama';
        $result = $con->query("SELECT derived.DayNumber, derived.42Approve as app1, derived2.44Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 42Approve FROM 42ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 44Approve FROM 44ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");

      }
    } else {
      //42 and 43
      $pres1='Clinton';
      $pres2='Bush 43';
      $result = $con->query("SELECT derived.DayNumber, derived.42Approve as app1, derived2.43Approve as app2 FROM (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 42Approve FROM 42ApprovalRatings) as derived INNER JOIN (SELECT ROW_NUMBER() OVER() DayNumber, Approve as 43Approve FROM 43ApprovalRatings) as derived2 ON derived.DayNumber=derived2.DayNumber");

    }
  }


    // a simple query on the Rawscores table

    if (!$result) {
      die("Query failed!\n");

    }
// PHP code about to end

?>
<!DOCTYPE html>
  <html>
  <head>
      <title>Comparing Approval Ratings Between </title>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                [{label: 'DayNumber', type: 'number'},{label:'P1',type:'number'},{label:'P2',type:'number'}],

                <?php
                    while($row = $result->fetch_assoc()){

                        echo "['".$row["DayNumber"]."', '".$row["app1"]."', ".$row["app2"]."],";
                    }
                ?>
               ]);

            var options = {
                title: 'Comparing Approval Ratings',
                curveType:'function' ,
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('compChart'));
            chart.draw(data, options);
          }

      </script>
  </head>
  <body>
       <div id="compChart" style="width: 900px; height: 400px"></div>
  </body>
  </html>
