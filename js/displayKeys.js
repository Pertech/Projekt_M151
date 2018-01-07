$().ready(function(){
  updateData();
});

function updateData(){
  $('.content').empty();
  $.getJSON( "../php/getActiveKeys.php", function(data) {
    var tableData = '<table class="table-striped"><tr><td>Id</td><td>Key</td></tr>';
    var items = [];
    $.each(data, function( key, val ) {
      tableData += '<tr><td>'+val.id+'</td><td>'+val.betakey+'</td><td><button onclick="removeKey(' + val.id + ')"></button></td></tr>';
    });
    tableData += '</table>';
    $('.content').html(tableData);
  });
}

function removeKey(id){
  $.post("test.php", { name: "John", time: "2pm" } );
}
