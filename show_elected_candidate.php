<head>
  <title>ShowElectedCandidate</title>
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

    $year = $_POST['year'];

    // This says that the $ID variable should be assigned a value obtained as an
    // input to the PHP code. In this case, the input is called 'ID'.
    if(!isset($year) || trim($year) == ''){
      echo "ERROR: YOU DID NOT FILL OUT THE FIELDS";
    } else if ($year%4 != 0 || $year>2016 || $year<1976) {
      echo "ERROR: The inputted year was not a valid election year";
    } else {
      mysqli_select_db($db, "20fa_jsong69_db");
      // ********* Remember to use the name of your database here ********* //

      $result = $db->multi_query("SELECT p.state_po,p.candidate, MAX(p.candidatevotes) as Candidate_Votes FROM PresHistory as p WHERE p.year = $year GROUP BY p.state");
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
            echo "<tr><td>STATE</td><td>CandidateName</td><td>CandidateParty</td></tr>\n";
            while ($row = $result->fetch_row()) {
              printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>\n", $row[0],
              $row[1], $row[2]);
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
