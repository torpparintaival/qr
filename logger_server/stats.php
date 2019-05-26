<?php

  include_once("DataBase.php");
  include_once("db_settings.php");

  $func = strtolower($_GET['func']);

  if ($func == "month") {
    $grouping_parameter = "%y-%m";
  }
  elseif ($func == "week") {
    $grouping_parameter = "%y-%v";
  }
  else {
    $grouping_parameter = "%y-%c-%d";
  }

  $db = new DataBase();
  if (! $db->open($DB_HOST, $DB_USER, $DB_PASS, $DB_BASE)) {
    error_log("Could not connect to database");
    exit(1);
  }

  $data = $db->get_stats($grouping_parameter);
  
  if (is_null($data)) {
    echo("No data");
  }
  else {
    $data_cols = Array('Group', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', 'Total');
    
    echo("<table>\n");

    echo("<tr>");
    foreach ($data_cols as $col) {
      echo("<th>$col</th>");
    }
    echo("</tr>\n");
    
    foreach ($data as $row) {
      echo("<tr>");
      foreach ($data_cols as $col) {
        echo("<td>".$row[$col]."</td>");
      }
      echo("</tr>\n");
    }
    
    echo("</table>");
  }

  $db->close();
?>

<ul>
  <li><a href="stats.php">Daily</a></li>
  <li><a href="stats.php?func=week">Weekly</a></li>
  <li><a href="stats.php?func=month">Monthly</a></li>
</ul>
