<?php

class DataBase {

  private $db = null;

  public function open ($address, $username, $password, $database) {
    $this->db = new mysqli($address, $username, $password, $database);
    if ($this->db->connect_errno) {
      $this->db = null;
      return false;
    }

    return true;
  }

  public function close () {
    if (!is_null($this->db)) {
      $this->db->close();
    }

    $this->db = null;
  }

  public function entries_in_minute ($ip) {
    if (is_null($this->db)) {
      return null;
    }

    $ip_esc = $this->db->real_escape_string($ip);

    $sql = 'SELECT COUNT(ip) as `hits` FROM `log` WHERE `ip`="'.$ip_esc.'" AND `time` > NOW() - INTERVAL 1 MINUTE';

    if (!$result = $this->db->query($sql)) {
      error_log("Error in MySQL statement (".$sql."): ".$this->db->error);
      return null;
    }

    $hits = null;

    while ($row = $result->fetch_assoc()) {
  		$hits = $row['hits'];
  	}

    return $hits;
  }

  public function add_log_entry ($data) {
    if (is_null($this->db)) {
      return null;
    }

    $sql_data = Array();

    foreach ($data as $this_key=>$this_value) {
      array_push($sql_data, '`'.$this_key.'`="'.$this->db->real_escape_string($this_value).'"');
    }

    $sql = 'INSERT INTO `log` SET '.join(', ', $sql_data);

    if (!$result = $this->db->query($sql)) {
      error_log("Error in MySQL statement (".$sql."): ".$this->db->error);
      return null;
    }

    return $this->db->affected_rows;
  }
  
  public function get_stats ($date_group) {
    if (is_null($this->db)) {
      return null;
    }

    $sql = "
      SELECT 
        DATE_FORMAT(time, '%s') AS `Group`,	
        SUM(href REGEXP '/01./$') AS `01`,
        SUM(href REGEXP '/02/$') AS `02`,
        SUM(href REGEXP '/03/$') AS `03`,
        SUM(href REGEXP '/04/$') AS `04`,
        SUM(href REGEXP '/05/$') AS `05`,
        SUM(href REGEXP '/06/$') AS `06`,
        SUM(href REGEXP '/07/$') AS `07`,
        SUM(href REGEXP '/08/$') AS `08`,
        SUM(href REGEXP '/09/$') AS `09`,
        SUM(href REGEXP '/10/$') AS `10`,
        SUM(href REGEXP '/11/$') AS `11`,
        SUM(href REGEXP '/12/$') AS `12`,
        SUM(href REGEXP '/13/$') AS `13`,
        SUM(href REGEXP '/14/$') AS `14`,
        SUM(href REGEXP '/15/$') AS `15`,
        COUNT(href) AS `Total`
      FROM `log`
      WHERE referrer=''
      GROUP BY DATE_FORMAT(time, '%s')
    ";
  
    $sql = sprintf($sql, $date_group, $date_group);
    
    if (!$result = $this->db->query($sql)) {
      error_log("Error in MySQL statement (".$sql."): ".$this->db->error);
      return null;
    }
    
    $data = Array();
    
    while ($row = $result->fetch_assoc()) {
      array_push($data, $row);
  	}

    return $data;
  }
}

?>
