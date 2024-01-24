<?php
define ('SITE_ROOT_DOWNLOAD', realpath(dirname(__FILE__, 2)));
include 'crud.php';
include 'notify_define.php';

$return_arr = array();
$varControl = $_POST['clicked'];

try {
  $varDownloadsCounter = getRegistryUploadDownloads($varControl);

  $file_path = SITE_ROOT_DOWNLOAD."//files/" . $varDownloadsCounter->name;
  $base64file = base64_encode(file_get_contents($file_path));

  $return_arr['filecontent'] = $base64file;

  $return_arr['objcontrol'] = $varDownloadsCounter->control;
  //$return_arr['objdate'] = $varDownloadsCounter->date;
  //$return_arr['objtime'] = $varDownloadsCounter->time;
  //$return_arr['objsize'] = $varDownloadsCounter->size;
  $return_arr['objtype'] = $varDownloadsCounter->type;
  $return_arr['objname'] = $varDownloadsCounter->name;
  $return_arr['objdownloads'] = $varDownloadsCounter->downloads;
  //$return_arr['downloadscounter'] = $varDownloadsCounter->downloads;
  $varDownloadsCounter->downloads++;
  //$return_arr['downloadscountermod'] = $varDownloadsCounter->downloads;

  $varResult = updateDownloadsCounter($varControl, $varDownloadsCounter->downloads);
  $return_arr['dbresult'] = $varResult;

  if($return_arr['dbresult'] >= 1){
    //$return_arr['sendDate'] = $varDate;
    //$return_arr['sendTime'] = $varTime;
    $return_arr['notifyMsg'] = NUMERO_DOWNLOADS_ATUALIZADO;
    $return_arr['notifyType'] = TYPE_SUCCESS;
    //$return_arr['whatsapp'] = sendWhatsAppMessage($varWhatsAppMessage);
  }else{
    // $return_arr['notifyMsg'] = OCORREU_ERRO_ADICIONAR;
    // $return_arr['notifyType'] = TYPE_ERROR;
    // $return_arr['whatsapp'] = OCORREU_ERRO_API;
}
  
  echo json_encode($return_arr);
} 
catch (Exception $e) {
  return 0;
  //echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>