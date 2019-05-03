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
}

?>
