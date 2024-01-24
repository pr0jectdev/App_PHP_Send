<?php include 'php/max_file_size.php'; ?>
<?php include 'php/check_registered_files.php'; ?>
<?php 
//echo $_SERVER['HTTP_HOST'];
//echo '<pre>'; print_r($_SERVER); echo '</pre>';
//print_r ($_SERVER["HTTP_X_REAL_IP"]);
//echo '<pre>'; print_r($_SERVER['HTTP_X_REAL_IP']); echo '</pre>';

// $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
//     ? $_SERVER['HTTP_CLIENT_IP'] 
//     : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
//       ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
//       : $_SERVER['REMOTE_ADDR']);

// echo 'O IP E: '.$ip;

$filesCounter = checkRegisteredFiles();

?>

<html>
<head>
  <link rel="stylesheet" href="css/sty1.css">
  <title>send</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="javascript/notify.min.js"></script>
  <link rel="shortcut icon" href="assets/favicon1.ico" type="image/x-icon">
  <link rel="icon" href="assets/favicon1.ico" type="image/x-icon">

  <!-- https://www.cluemediator.com/ajax-post-request-with-jquery-and-php -->
</head>

<!-- <body oncontextmenu="return false;"> -->
<body>

  <div class="wrapper">
    <!-- DIV WRAPPER -->
    <!-- <script src="scripts/desativar.js"></script> -->
    
    <script src="javascript/form_send.js"></script>
    <script src="javascript/form_delete.js"></script>
    <script src="javascript/form_upload.js"></script>
    <script src="javascript/form_download.js"></script>

    <table class="Tabela_1">
      <tr>
        <th></th>
        <th></th>
      </tr>
      <tr>
        <td id='tdSEND'>

          <?php // = = = = = TEXT AREA = = = = =
          //<button class="send1" id="369" onclick="reqpass2(this.id)">del</button>
          ?>
          <form>
          <div class="textoverde pictureframe marginbottom">To Do List</div><br>
            <textarea cols="50" rows="1" id="about" style="text-transform:uppercase"></textarea><br><br>
            <textarea cols="90" rows="10" id="comments" wrap="hard" style="text-transform:uppercase"></textarea><br><br>
            <table class="Envia">
              <tr>
                <td align="center"><input type="checkbox" id="CheckboxJob"><div class="textoverdeenvia pictureframe">Enviar e-mail job</div></th>
                <td align="center"><input type="checkbox" id="CheckboxEmail"><div class="textoverdeenvia pictureframe">Enviar e-mail</div></th>
                <td align="center"><input type="checkbox" id="CheckboxWhatsApp"><div class="textoverdeenvia pictureframe">Enviar WhatsApp</div></th>
                <td align="center"><input type="button" class="send1" id="btnSubmit" value="send" /></th>
              </tr>
            </table>
          <!-- Se console limpar sozinho mudar de type: submit para type: button -->
          </form>

          <div id="valueAbout" class="textobranco pictureframe"></div>
          <div id="valueComments" class="textobranco pictureframe"></div>
          <div id="valueFullDate" class="textobranco pictureframe"></div>
          <div id="valueDBRsult" class="textoverde pictureframe"></div>
          <!-- FORM SEND -->

        </td>
        <td id='tdUPLOAD'>
          <form id="form" method="post" enctype="multipart/form-data">
          <div class="textoverde pictureframe marginbottom">Upload file</div><br><br>
            <input type="file" name="arquivo" class="bUpload" id="arquivo"><br>
            <br>
            <input type="submit" name="submit" class="bUpload" id="submit" value="Upload">
            <br><br>
            <div class="textobranco pictureframe marginbottom"><strong>Extension:</strong> zip, 7z, rar, mp3, xml, docx, jpg, png, jpeg, gif</div>
            <br>
            <div class="textobranco pictureframe"><strong>Max file size: </strong><?php  echo $uploadMaxFileSizeString; ?></div>
          </form>



          <!-- INFO: Date, time, Name, Size, Type, Ext -->
          <div class="textodados" id="uploadInfo"></div>
          <p></p>

          <!-- Uploaded, Total -->
          <div class="textoSizeProgress" id="SizeProgress"></div>

          <!-- Status % -->
          <div class="progress" id="z">
            <div class="progress-bar" id="z"></div>
          </div>

          <!-- Uploaded, Total -->
          <p>upload total</p>
          <div id="uploadStatus" class="z"></div>

        </td>
      </tr>
    </table>

    <br>
    <center><span class="textobranco pictureframe"><?php echo 'Number of files: '.$filesCounter->filesInDataBase.' (Removed: '.$filesCounter->filesRemoved.')'; ?></span></center>

    <?php
    //include 'php/crud.php';

    //$varListFiles = getRegistryUpload();
    $varListFiles = $filesCounter->resultListFiles;
    if (count($varListFiles) > 0) {
      echo "<table id='tableRegistryUpload' class='lista'>";
      echo "
      <thead><tr>
      <th style='width:3%' id='thID'>ID
      <th style='width:8%' id='thDate'>Date
      <th style='width:6%' id='thTime'>Time
      <th style='width:10%' id='thSize'>Size (MB)
      <th style='width:10%' id='thType'>Type
      <th style='width:8%' id='thExistsFile'>Exists
      <th style='width:44%' id='thNameFile'>Name
      <th style='width:5%' id='thDownloadsCounter'>dwl counter
      <th style='width:3%' id='thDownload'>download
      <th style='width:3%' id='thDelete'>delete
      </thead><tbody>";

      foreach($varListFiles as $files){
        echo "<tr id=". $files->control ."><td id='tdID'>" . $files->control . "</td>";
        echo "<td id='tdDate'>" . $files->date . "</td>";
        echo "<td id='tdTime'>" . $files->time . "</td>";
        echo "<td id='tdSize'>" . $files->size . "</td>";
        echo "<td id='tdType'> " . $files->type . "</td>";
        echo "<td id='tdExistsFile'>" . $files->exists . "</td>";
        echo "<td id='tdNameFile'>" . $files->name . "</td>";
        echo "<td id='tdDownloadsCounter'>" . $files->downloads . "</td>";
        echo "<td id='tdDownload'><button class='send1' id=" . $files->control . " onclick='downloadFile(this.id)'>download</button></td>";
        echo "<td id='tdDelete'><button class='send1' id=" . $files->control . " onclick='deleteRegistryUpload(this.id)'>delete</button></td>";
        echo "<td></td></tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<table id='tableRegistryUpload' class='lista'>";
      echo "
      <thead><tr>
      <th style='width:3%' id='thID'>ID
      <th style='width:8%' id='thDate'>Date
      <th style='width:6%' id='thTime'>Time
      <th style='width:10%' id='thSize'>Size (bytes)
      <th style='width:10%' id='thType'>Type
      <th style='width:8%' id='thExistsFile'>Exists
      <th style='width:49%' id='thNameFile'>Name
      <th style='width:3%' id='thDownload'>download
      <th style='width:3%' id='thDelete'>delete
      </thead><tbody>";
      echo "<tr><td id='tdID'></td><td id='tdDate'></td><td id='tdTime'></td><td id='tdSize'></td>";
      echo "<td id='tdType'></td><td id='tdExistsFile'></td><td id='tdNameFile'></td><td id='tdDownload'></td>";
      echo "<td id='tdDelete'></td><td></td></tr>";
      echo "<tr><td id='tdNoResult' colspan='9'>Nenhum resultado encontrado</td></tr>";
      echo "<tr><td id='tdID'></td><td id='tdDate'></td><td id='tdTime'></td><td id='tdSize'></td>";
      echo "<td id='tdType'></td><td id='tdExistsFile'></td><td id='tdNameFile'></td><td id='tdDownload'></td>";
      echo "<td id='tdDelete'></td><td></td></tr>";
      echo "</tbody></table>";
    }
    

    // TABLE REGISTRY
    $tableHeadRegistry = "
    <table id='tableRegistry' class='lista'><thead><tr>
    <th style='width:3%' id='thID'>ID
    <th style='width:8%' id='thDate'>Date
    <th style='width:6%' id='thTime'>Time
    <th style='width:25%' id='thAbout'>About
    <th style='width:55%' id='thComment'>Comment
    <th style='width:3%' id='thDel'>delete
    </thead><tbody>";
    $tableRegistryEnd = "</tbody></table>";
    $tableRegistryNotFoundHead = "
    <table id='tableRegistry' class='lista'><thead><tr>
    <th style='width:3%' id='thID'>ID
    <th style='width:8%' id='thDate'>Date
    <th style='width:6%' id='thTime'>Time
    <th style='width:25%' id='thAbout'>About
    <th style='width:55%' id='thComment'>Comment
    <th style='width:3%' id='thDel'>delete
    </thead><tbody>";
    $tableRegistryNotFoundBlank = "<tr><td id='tdID'></td><td id='tdDate'></td><td id='tdTime'></td><td id='tdAbout'></td>
    <td id='tdComment'></td><td id='tdDelete'></td><td></td></tr>";
    $tableRegistryNotFound = "<tr><td id='tdNoResult' colspan='6'>Nenhum resultado encontrado</td></tr>";

    $varQueryResult = getRegistry();
    if ($varQueryResult->num_rows > 0) {
      echo $tableHeadRegistry;
      while ($row = $varQueryResult->fetch_assoc()) {
        echo "<tr id=". $row["control"] ."><td id='tdID'>" . $row["control"] . "</td>";
        echo "<td id='tdDate'>" . $row["date"] . "</td>";
        echo "<td id='tdTime'>" . $row["time"] . "</td>";
        echo "<td id='tdAbout'>" . $row["about"] . "</td>";
        echo "<td id='tdComment'> " . nl2br($row["comment"]) . "</td>";
        echo "<td id='tdDelete'><button class='send1' id=" . $row["control"] . " onclick='deleteRegistry(this.id)'>delete</button></td>";
        echo "<td></td></tr>";
      }
      echo $tableRegistryEnd;
    } else {
      echo $tableRegistryNotFoundHead;
      echo $tableRegistryNotFoundBlank;
      echo $tableRegistryNotFound;
      echo $tableRegistryNotFoundBlank;
      echo $tableRegistryEnd;
    }
    ?>

    <div class="push"></div>
  </div> <!-- DIV WRAPPER -->
  <div class="footer">
    <div id="valueFooter" class="textoverde pictureframe">Developer: Marcio Barcellos | Created on: 24/08/2019 | Last update: 03/04/2020 > 14/02/2022 > 03/10/2022 > 14/12/2023</div>  
  </div>

</body>
</html>