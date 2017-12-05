(function() {
  var listMedic = new Array();

  $.ajax({
       url : '/medecin/getMedic.php',
       type: 'GET',
       success: function(ret, statut) {
         for (var i = 0; i < ret.length; i++) {
           listMedic.push(ret[i][1]);
         }
         $("#delMedic").autocomplete({
           source: listMedic
         });
      $('.ui-autocomplete').css("background-color", "#cdcdcd");
       }
    });
}(jQuery));
