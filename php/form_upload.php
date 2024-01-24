<?php
//define ('SITE_ROOT', realpath(dirname(__FILE__, 1)));
define ('SITE_ROOT_UPLOAD', realpath(dirname(__FILE__, 2)));

include 'crud.php';
include 'notify_define.php';
include 'api_whatsapp.php';
include 'max_file_size.php';

$return_arr = array();

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}

$guid = getGUID();
$guidNumber = preg_replace('/[^0-9]+/', '', $guid);
$guidLetter = preg_replace('/[^A-Z]+/', '', $guid);
$guidTmp = $guidNumber.$guidLetter;
$guidFinal = preg_replace('/-+/', '', $guidTmp);

$ipOfUploader = strlen($_SERVER['REMOTE_ADDR']) > 5 ? $_SERVER['REMOTE_ADDR'] : strlen($_SERVER['REMOTE_ADDR']);
date_default_timezone_set("America/Sao_Paulo");
//$uploadDate=date("Y-m-d H:i:s");
//$x_dateF=date("Y-m-d_H-i-s");
$varUploadDate = date("Y/m/d");
$varUploadTime = date("H:i:s");

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    
    if(isset($_FILES["arquivo"]) && $_FILES["arquivo"]["error"] == 0){

        //$allowed = array('zip', '7z', 'rar', 'mp3', 'xml', 'docx', 'jpg', 'png', 'jpeg', 'gif', 'exe'); 
        $allowed = array('zip', '7z', 'rar', 'mp3', 'xml', 'docx', 'jpg', 'png', 'jpeg', 'gif', 'exe'); 
        
        $fileName = $_FILES["arquivo"]["name"];
        $fileType = $_FILES["arquivo"]["type"];
        $fileSize = $_FILES["arquivo"]["size"];                                
        
        $fileNameTmp1 = str_replace(' ', '-', $fileName);
        $fileNameTmp2 = preg_replace('/[^A-Za-z0-9\-\.\_]/', '', $fileNameTmp1);
        $fileNameTmp3 = preg_replace('/-+/', '-', $fileNameTmp2);
        $fileNameFinal = $guidFinal."_".$fileNameTmp3;
        $fileExt = pathinfo($fileNameFinal, PATHINFO_EXTENSION);
        //if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");                       
    
        // Verify file size
        //$maxsize = 32 * 1024 * 1024;
        
        $maxSize = $uploadMaxFileSize * 1024 * 1024;
        if($fileSize > $maxSize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        //if(in_array($filetype, $allowed)){

        if(in_array($fileExt, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists(SITE_ROOT_UPLOAD."//files/" . $fileNameFinal)){
                //echo $fileNameFinal . " already exists.";
            } else{
                $fileSizeFinal = number_format($fileSize/1024/1024, 2); //7.702408790588379
                move_uploaded_file($_FILES["arquivo"]["tmp_name"], SITE_ROOT_UPLOAD.'//files/'. $fileNameFinal);
                
                $return_arr['uploadDate'] = $varUploadDate;
                $return_arr['uploadTime'] = $varUploadTime;
                $return_arr['fileSize'] = $fileSizeFinal;
                $return_arr['fileType'] = $fileType;
                $return_arr['fileName'] = $fileNameFinal;

                $return_arr['combinedResult'] = "Date: " .$varUploadDate. " _                
                Time: " .$varUploadTime. "<br>           
                Name: " .$fileNameFinal. "<br>                             
                Size: " .$fileSizeFinal. " bytes<br>                                                          
                Type: " .$fileType. " _ 
                Ext: " .$fileExt. "<br>";
                
                // echo "<textoDados>";
                // echo "Date: " . $varUploadDate . " _ ";                
                // echo "Time: " . $varUploadTime . "<br>";                
                // echo "Name: " . $fileNameFinal . "<br>";                              
                // echo "Size: " . $fileSizeFinal . " bytes<br>";                                                              
                // echo "Type: " . $fileType . " _ ";  
                // echo "Ext: " . $fileExt . "<br>";  
                // echo "</textoDados>";
                
                if(file_exists(SITE_ROOT_UPLOAD."//files/" . $fileNameFinal)){
                    $return_arr['fileUploadResult'] = 'Your file was uploaded successfully';
                    //echo "<br><textoRes>[[ Your file was uploaded successfully ]]</textoRes>";                                               
                }else{
                    $return_arr['fileUploadResult'] = 'Your file NOT exists';
                    //echo "<br><textoRes>[[ Your file NOT exists ]]</textoRes>";                                               
                }
                
                $return_arr['dbresult'] = insertRegistryUpload($varUploadDate, $varUploadTime, $fileNameFinal, $fileSizeFinal, $fileType, $ipOfUploader);
                if($return_arr['dbresult'] >= 1){
                    $return_arr['notifyMsg'] = $return_arr['dbresult'].REGISTRO_ADICIONADO;
                    $return_arr['notifyType'] = TYPE_SUCCESS;
                    //$return_arr['whatsapp'] = sendWhatsAppMessage($varWhatsAppMessage);
                }else{
                    $return_arr['notifyMsg'] = OCORREU_ERRO_ADICIONAR;
                    $return_arr['notifyType'] = TYPE_ERROR;
                    //$return_arr['whatsapp'] = OCORREU_ERRO_API;
                }
                //echo json_encode($return_arr);
            } 
        } else{
            $return_arr['uploadError'] = 'There was a problem uploading your file. Please try again';
            //echo "<textoerro>[ Error: There was a problem uploading your file. Please try again. ]</textoerro>"; 
        }
    } else{
        $return_arr['uploadError'] = 'Error: ' . $_FILES["arquivo"]["error"];
        //echo "<textoerro>[ Error: " . $_FILES["arquivo"]["error"] . " ]</textoerro>";
    }
}
//var_dump($return_arr);
//print_r ($return_arr);
echo json_encode($return_arr);



/*

CREATE TABLE `filesend` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `date` datetime NOT NULL,
    `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
    `size` float NOT NULL,
    `type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
    `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

*/

?>