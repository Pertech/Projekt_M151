$().ready(function(){
  updateData();
});

function updateData(){
  $('.content').empty();
  $.getJSON( "../php/getRequests.php", function(data) {
    var tableData = '<table class="table-striped"><tr><td>Id</td><td>Username</td><td></td><td></td></tr>';
    var items = [];
    $.each(data, function( key, val ) {
      tableData += '<tr><td>'+val.id+'</td><td>'+val.username+'</td><td><button onclick="acceptRequest(' + val.id + ')">accept</button><td><button onclick="declineRequest(' + val.id + ')">decline</button></td></tr>';
    });
    tableData += '</table>';
    $('.content').html(tableData);
  });
}

function acceptRequest(id){
  $.post("../php/acceptRequest.php", { requestID: id }, function(){
    updateData();
  });
}

function declineRequest(id){
  $.post("../php/declineRequest.php", { requestID: id }, function(){
    updateData();
  });
}
