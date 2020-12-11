<head>
  <title>ShowBushAverage</title>
</head>
<body>



  <?php
  // PHP code just started

  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', true);
  // display errors
  $dbhost = 'dbase.cs.jhu.edu';
  $dbuser = '20fa_jsong69';
  $dbpass = 'Jv6g8ON4Pg';
  $db = mysqli_connect($dbhost, $dbuser, $dbpass);
  // ********* Remember to use your MySQL username and password here ********* //

  if (!$db) {

    echo "Connection failed!";

  } else {
    $date_1 = $_POST['date1'];
    $date_2 = $_POST['date2'];

    $date_bush_begin = "2001-02-01";
    $date_bush_end = "2009-01-10";
    // This says that the $ID variable should be assigned a value obtained as an
    // input to the PHP code. In this case, the input is called 'ID'.
    if(!isset($date_1) || trim($date_1) == ''){
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if (!isset($date_2) || trim($date_2) == '') {
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if ($date_1 < $date_bush_begin || $date_2 > $date_bush_end) {
      echo "ERROR: Inputted invalid dates during Trump's presidency";
    } else {
      mysqli_select_db($db, "20fa_jsong69_db");
      // ********* Remember to use the name of your database here ********* //
      $result = $db->multi_query("SELECT avg(Approve) FROM 43ApprovalRatings WHERE DAY >= '$date_1' AND DAY <= '$date_2'");
      // a simple query on the Rawscores table

      if (!$result) {

        echo "Query failed!\n";
        print mysqli_error($db);

      } else {

        if ($result = $db->store_result()) {
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
            echo "<tr><td>Average Approval Ratings</td></tr>\n";
            while ($row = $result->fetch_row()) {
              printf("<tr><td>%s</td></tr>\n", $row[0]);
            }
            echo "</table>\n";
          }
          $result->close();
        }

      }

    }
  }

  // PHP code about to end

  ?>



</body>
