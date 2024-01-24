function deleteRegistryUpload(clicked) {
  var pwd = prompt("Password", "");

  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: "php/delete_registry_upload.php",
    data: {pwd: pwd, clicked: clicked},
    cache: false,
    beforeSend: function() {
      //console.log('deleteRegistryUpload');
      //console.log('pwd x: ' + pwd);
      //console.log('clicked x: ' + clicked);
    },
    success: function(data) {
      $.notify(data.notifyMsg, data.notifyType);
      if(data.dbresult >= 1){
        $('table#tableRegistryUpload tr#' + clicked).remove();
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    }
  });
}

function deleteRegistry(clicked) {
  var pwd = prompt("Password", "");

  $.ajax({
    type: "POST",
    dataType: 'JSON',
    url: "php/delete_registry.php",
    data: {pwd: pwd, clicked: clicked},
    cache: false,
    beforeSend: function() {
      //console.log('pwd x: ' + pwd);
      //console.log('clicked x: ' + clicked);
    },
    success: function(data) {
      $.notify(data.notifyMsg, data.notifyType);
      if(data.dbresult >= 1){
        $('table#tableRegistry tr#' + clicked).remove();
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    }
  });
}