$().ready(function(){
  updateData();
});

function updateData(){
  $.getJSON( "../php/getActiveKeys.php", function(data) {
    $('.content').empty();
    var tableData = '<table class="table-striped"><tr><td>Id</td><td>Key</td></tr>';
    var items = [];
    $.each(data, function( key, val ) {
      tableData += '<tr><td>'+val.id+'</td><td>'+val.betakey+'</td></tr>';
    });
    tableData += '</table>';
    $('.content').html(tableData);
  });
}
