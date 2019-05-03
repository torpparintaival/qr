<?php

  header("Access-Control-Allow-Origin: https://torpparintaival.github.io");

  include_once("DataBase.php");
  include_once("db_settings.php");

  $MAX_LENGTH = 64;
  $RATE_LIMIT_IN_MINUTE = 5;

  if (!array_key_exists('data', $_POST)) {
    exit(0);
  }

  $data = json_decode($_POST['data'], true);

  $data_final = Array(
    'ip' => $_SERVER['REMOTE_ADDR'],
    'href' => '',
    'referrer' => '',
    'target' => '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT']
  );

  if (array_key_exists('href', $data)) {
    $data_final['href'] = substr($data['href'], 0, $MAX_LENGTH);
  }

  if (array_key_exists('referrer', $data)) {
    $data_final['referrer'] = substr($data['referrer'], 0, $MAX_LENGTH);
  }

  if (array_key_exists('target', $data)) {
    $data_final['target'] = substr($data['target'], 0, $MAX_LENGTH);
  }

  if (array_key_exists('user_agent', $data)) {
    $data_final['user_agent'] = substr($data['user_agent'], 0, $MAX_LENGTH);
  }

  $db = new DataBase();
  if (! $db->open($DB_HOST, $DB_USER, $DB_PASS, $DB_BASE)) {
    error_log("Could not connect to database");
    exit(1);
  }

  $former_entries = $db->entries_in_minute($data_final['ip']);
  if (!is_null($former_entries) and $former_entries < $RATE_LIMIT_IN_MINUTE) {
    // Submit data
    $db->add_log_entry($data_final);
  }

  $db->close();
?>
