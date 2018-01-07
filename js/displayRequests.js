$().ready(function(){
  updateData();
});

function updateData(){
  $.getJSON( "../php/getRequests.php", function(data) {
    $('.content').empty();
    var tableData = '<table class="table-striped"><tr><td>Id</td><td>Username</td></tr>';
    var items = [];
    $.each(data, function( key, val ) {
      tableData += '<tr><td>'+val.id+'</td><td>'+val.username+'</td></tr>';
    });
    tableData += '</table>';
    $('.content').html(tableData);
  });
}
