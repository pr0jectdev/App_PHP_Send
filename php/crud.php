<?php declare(strict_types=1);
include 'database.php';

$varMensagemSucesso = "Registry added";
$varMensagemErro = "An error occurred when submitting your registry";

//function getRegistry(string $varDate, string $varTime, string $varAbout, string $varComments) {
function getRegistry() {
  $stmt = $GLOBALS['conn']->prepare("SELECT control, date, time, about, comment FROM app_send_control ORDER BY control DESC");
  $stmt->execute();
  $varQueryResult = $stmt->get_result();
  return $varQueryResult;
}

class filesInfo {
  public $exists;
  public $control;
  public $date;
  public $time;
  public $size;
  public $type;
  public $name;
  public $downloads;
  public $ip;
}

function getRegistryUpload() {
  $stmt = $GLOBALS['conn']->prepare("SELECT control, date, time, name, size, type, ip, downloads FROM app_send_file ORDER BY control DESC");
  $stmt->execute();
  $varQueryResult = $stmt->get_result();
  //return $varQueryResult;
  
  if($varQueryResult->num_rows > 0){
    $filesInfoList = [];
    define ('SITE_ROOT_CRUD', realpath(dirname(__FILE__, 2)));

    while($row = $varQueryResult->fetch_assoc()){
      $filesInfoNew =  new filesInfo();
      $filesInfoNew->exists = file_exists(SITE_ROOT_CRUD."//files/" . $row["name"]) ?  'Yes' : 'No';
      $filesInfoNew->control = $row["control"];
      $filesInfoNew->date = $row["date"];
      $filesInfoNew->time = $row["time"];
      $filesInfoNew->size = $row["size"];
      $filesInfoNew->type = $row["type"];
      $filesInfoNew->name = $row["name"];
      $filesInfoNew->downloads = $row["downloads"];
      $filesInfoNew->ip = $row["ip"];
      $filesInfoList[] = $filesInfoNew;
    }
    return $filesInfoList;
  }else{
    $filesInfoList = [];
    return $filesInfoList;
  }
  //print_r($filesInfoNew);
  //var_dump($filesInfoList);
}

function getRegistryUploadDownloads(string $varControl) {
  $stmt = $GLOBALS['conn']->prepare("SELECT control, date, time, name, size, type, ip, downloads FROM app_send_file WHERE control = ?");
  $stmt->bind_param("s", $varControl);
  $stmt->execute();
  $varQueryResult = $stmt->get_result();
  
  if($varQueryResult->num_rows > 0){
    while($row = $varQueryResult->fetch_assoc()){
      $filesInfoNew =  new filesInfo();
      $filesInfoNew->control = $row["control"];
      $filesInfoNew->date = $row["date"];
      $filesInfoNew->time = $row["time"];
      $filesInfoNew->size = $row["size"];
      $filesInfoNew->type = $row["type"];
      $filesInfoNew->name = $row["name"];
      $filesInfoNew->downloads = $row["downloads"];
      $filesInfoNew->ip = $row["ip"];
      $filesInfoList[] = $filesInfoNew;
    }
    return $filesInfoNew;
  }else{
    $filesInfoNew =  new filesInfo();
    return $filesInfoNew;
  }
}

function insertRegistry(string $varDate, string $varTime, string $varAbout, string $varComments) {
  try {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO app_send_control (date, time, about, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $varDate, $varTime, $varAbout, $varComments);
    $stmt->execute();
    $varAffectedRows = $stmt->affected_rows;
    return $varAffectedRows;
  } 
  catch (Exception $e) {
    return 0;
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
}

function insertRegistryUpload(string $varDate, string $varTime, string $varFileName, string $varFileSize, string $varFileType, string $varIp) {
  $stmt = $GLOBALS['conn']->prepare("INSERT INTO app_send_file (date, time, name, size, type, ip) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $varDate, $varTime, $varFileName, $varFileSize, $varFileType, $varIp);
  $stmt->execute();
  $varAffectedRows = $stmt->affected_rows;
  return $varAffectedRows;
}

function deleteRegistry(string $varControl) {
  try {
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM app_send_control WHERE control = ?");
    $stmt->bind_param("s", $varControl);
    $stmt->execute();
    $varAffectedRows = $stmt->affected_rows;
    return $varAffectedRows;
  } 
  catch (Exception $e) {
    return 0;
  }
}

function deleteRegistryUpload(string $varControl) {
  try {
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM app_send_file WHERE control = ?");
    $stmt->bind_param("s", $varControl);
    $stmt->execute();
    $varAffectedRows = $stmt->affected_rows;
    return $varAffectedRows;
  } 
  catch (Exception $e) {
    return 0;
  }
}

function updateDownloadsCounter(string $varControl, string $varCounter) {
  try {
    $stmt = $GLOBALS['conn']->prepare("UPDATE app_send_file SET downloads = ? WHERE control = ?");
    $stmt->bind_param("ss", $varCounter, $varControl);
    $stmt->execute();
    $varAffectedRows = $stmt->affected_rows;
    return $varAffectedRows;
  } 
  catch (Exception $e) {
    return 0;
  }
}

// try {

// } 
// catch (Exception $e) {
//   return 0;
// }

//include 'php/form_send_email.php';


    //https://www.php.net/manual/en/mysqli-stmt.bind-param.php
    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    // i - integer
    // d - double
    // s - string
    // b - BLOB

?>