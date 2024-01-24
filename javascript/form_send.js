$(document).ready(function() { 

  //console.log('hostname: ' + window.location.hostname);
  //console.log('pathname: ' + window.location.pathname);

  $("#btnSubmit").click(function() {
      var about = $("#about").val();
      var comments = $("#comments").val();

      if(about==''||comments=='') {
        alert("Please fill all fields.");
        //return false;
      }else{
        $.ajax({
          method: "POST",
          dataType: 'JSON',
          url: "php/form_send.php",
          data: {
              about: about,
              comments: comments
          },
          cache: false,
          success: function(data) {
            //console.log('data send: ' + JSON.stringify(data));
            $.notify(data.notifyMsg, data.notifyType);
            //$.notify(data.whatsapp, data.notifyType);
            $('#about').val("");
            $('#comments').val("");
            
            if(data.dbresult >= 1){
              $('#valueAbout').text("[ " + data.about);
              $('#valueComments').text(" / " + data.comments);
              $('#valueFullDate').text(" / " + data.fulldate + " ]");

              $("#tableRegistry").prepend("<tr><td id='tdID'>???</td>" + 
              "<td id='tdDate'>" + data.sendDate + "</td>" +
              "<td id='tdTime'>" + data.sendTime + "</td>" +
              "<td id='tdAbout'>" + about.toUpperCase() + "</td>" +  
              "<td id='tdComment'>" + comments.toUpperCase() + "</td>" +
              "<td id='tdDelete'>???</td>" +
              "<td></td></tr>")
            }
            //console.log(data.notifyMsg);
            //console.log(data.notifyType);
            //$('#valueDBRsult').text(data.dbresult);
          },
          error: function (request, status, error) {
            //alert(request.responseText);
            $('#valueComments').text(request.responseText);
          }
        });
      }
  });
});
