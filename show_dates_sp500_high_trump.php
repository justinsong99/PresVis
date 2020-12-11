<head>
  <title>ShowDates</title>
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

    $high_or_low = $_POST['high_or_low'];

    // This says that the $ID variable should be assigned a value obtained as an
    // input to the PHP code. In this case, the input is called 'ID'.
      mysqli_select_db($db, "20fa_jsong69_db");
      // ********* Remember to use the name of your database here ********* //
      if (strcmp($high_or_low, "high") == 0) {
        $result = $db->multi_query("SELECT Date, High FROM sp500 as sp, 45ApprovalRatings as ar WHERE ar.Day=sp.Date AND ar.approve IN (SELECT max(approve) FROM 45ApprovalRatings)");
      } else {
        $result = $db->multi_query("SELECT Date, Low FROM sp500 as sp, 45ApprovalRatings as ar WHERE ar.Day=sp.Date AND ar.approve IN (SELECT max(approve) FROM 45ApprovalRatings)");
      }
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
            echo "<tr><td>Dates</td><td>SP500</td></tr>\n";
            while ($row = $result->fetch_row()) {
              printf("<tr><td>%s</td><td>%s</td></tr>\n", $row[0],
              $row[1]);
            }
            echo "</table>\n";
          }
          $result->close();
        }

      }
  }

  // PHP code about to end

  ?>



</body>
