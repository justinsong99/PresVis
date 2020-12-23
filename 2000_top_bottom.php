<head>
  <title>Show top 20% and bottom 80%</title>
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

    $num = $_POST['num'];

    // This says that the $ID variable should be assigned a value obtained as an
    // input to the PHP code. In this case, the input is called 'ID'.
    if(!isset($num) || trim($num) == ''){
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if ($num>2020 || $num<2000) {
      echo "ERROR: The inputted count was not valid";
    } else {
      mysqli_select_db($db, "20fa_jsong69_db");
      // ********* Remember to use the name of your database here ********* //

      $result = $db->multi_query("SELECT Year FROM (SELECT Year,Lowest_fifth+Second_Fifth+Third_Fifth+Fourth_Fifth as 80thPercentileandBelow, Highest_Fifth as Top20Percent FROM IncomeDist WHERE Year>=$num) as derived WHERE derived.Top20Percent>derived.80thPercentileandBelow");
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
            echo "<tr><td>Year</td></tr>\n";
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
