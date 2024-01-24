<?php
include 'crud.php';
include 'notify_define.php';

$return_arr = array();
$varPwd = $_POST['pwd'];
$varControl = $_POST['clicked'];
$varWrongPassword = 'Senha errada';
//$varTeste = 'hohoho';

if($varPwd != '' && $varPwd == SENHA){
    $return_arr['dbresult'] = deleteRegistry($varControl);
    if($return_arr['dbresult'] >= 1){
        $return_arr['notifyMsg'] = $return_arr['dbresult'].REGISTRO_REMOVIDO;
        $return_arr['notifyType'] = TYPE_SUCCESS;
    }else{
        $return_arr['notifyMsg'] = OCORREU_ERRO;
        $return_arr['notifyType'] = TYPE_ERROR;
    }
}else{
    $return_arr['notifyMsg'] = WRONG_PASSWORD;
    $return_arr['notifyType'] = TYPE_WARN;
}

echo json_encode($return_arr);
?>