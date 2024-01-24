$(document).ready(function(e) {
  $("#form").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    //formData.append('x_date1', date1);	
    //formData.append('x_dateF', dateF);			                                   
    $.ajax({ //ajax
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            var percentComplete = ((evt.loaded / evt.total) * 100);
            $(".progress-bar").width(percentComplete + '%');
            $(".progress-bar").html('<textoStatus>Status: ' + Math.round(percentComplete) + '%</textoStatus>');
            $("#SizeProgress").html('<textoRes>Uploaded: ' + evt.loaded / 1000 + ' bytes</textoRes><br><textoRes>Total: ' + evt.total / 1000 + ' bytes</textoRes>');
          }
        }, false);
        return xhr;
      },
      method: 'POST',
      dataType: 'JSON',
      url: 'php/form_upload.php',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('#form').css("opacity", ".5");
        $("#submit").prop('disabled', true);
        $("#arquivo").prop('disabled', true);
      },
      // error: function() {
      //   $('#uploadStatus').html('<p><textoerro>File upload failed, please try again.</textoerro></p>');
      // },
      success: function(data) {
        //console.log('data: ' + JSON.stringify(data));
        $.notify(data.notifyMsg, data.notifyType);
        //$.notify(data.whatsapp, data.notifyType);

        $('#uploadInfo').html(data.combinedResult);
        $('#form')[0].reset();
        $('#form').css("opacity", "");
        $("#submit").prop('disabled', false);
        $("#arquivo").prop('disabled', false);

        $("#tableRegistryUpload").prepend("<tr><td id='tdID'>???</td>" +
        "<td id='tdDate'>" + data.uploadDate + "</td>" +
        "<td id='tdTime'>" + data.uploadTime + "</td>" +
        "<td id='tdSize'>" + data.fileSize + "</td>" +
        "<td id='tdType'> " + data.fileType + "</td>" +
        "<td id='tdExistsFile'>???</td>" +
        "<td id='tdNameFile'>" + data.fileName + "</td>" +
        "<td id='tdDownload'>???</td>" +
        "<td id='tdDelete'>???</td>" +
        "<td></td></tr>")

        //x_arquivos();
        //$('#x_resultado').text(mostra1);               	   
      },
      error: function (request, status, error) {
        //alert(request.responseText);
        $('#valueComments').text(request.responseText);
      }
    }); //ajax  
  });
});
