function downloadFile(clicked) {

  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: "php/download_file.php",
    data: {clicked: clicked},
    cache: false,
    beforeSend: function() {
      //console.log('clicked: ' + clicked);
    },
    success: function(data) {
      if(data.dbresult >= 1){
        $.notify(data.notifyMsg, data.notifyType);
        var counter = $('table#tableRegistryUpload tr#' + clicked).find('td:eq(7)').text();
        counter++;
        $('table#tableRegistryUpload tr#' + clicked).find('td:eq(7)').text(counter);
      };

      var a = document.createElement("a");
      a.download = data.objname;
      a.href = 'data:' + data.objtype + ';base64,' + data.filecontent;
      a.click();
      //a.href = "data:image/png;base64," + data.filecontent;
    },
    error: function (request, status, error) {
      alert(request.responseText);
    }
  });
}