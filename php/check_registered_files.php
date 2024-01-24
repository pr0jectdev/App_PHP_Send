<?php
define ('SITE_ROOT_CHECK', realpath(dirname(__FILE__, 2)));
include 'php/crud.php';

function checkRegisteredFiles() {
  try {
    class resultCounter{
      public $filesRemoved = 0;
      public $filesInDataBase = 0;
      public $resultListFiles;
    }

    $resultCounter =  new resultCounter();
    $filesName = [];
    $pathOfFiles = 'files';
    $filesInFolder = array_diff(scandir($pathOfFiles), array('.', '..'));
    //echo sizeof($filesTmp);
    //var_dump($filesInFolderCounter);

    $varListFiles = getRegistryUpload();
    $resultCounter->resultListFiles = $varListFiles;
    
    if (count($varListFiles) > 0){
      foreach($varListFiles as $reg){
        array_push($filesName, $reg->name);
      }

      $resultRemoved = array_diff($filesInFolder,$filesName);
      
      foreach($resultRemoved as $name){
        if (!unlink(SITE_ROOT_CHECK."//files/" . $name)) { 
          echo ("$name cannot be deleted due to an error"); 
        } 
        else { 
          $resultCounter->filesRemoved++;
          //echo ("$name has been deleted"); 
        } 
      }
      
      //$resultCounter->filesRemoved = sizeof($resultRemoved);
      $resultCounter->filesInDataBase = sizeof($varListFiles);
    }
    return $resultCounter;
  } 
  catch (Exception $e) {
    return 17012024;
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
}


?>