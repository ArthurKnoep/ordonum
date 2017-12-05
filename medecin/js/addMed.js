(function() {
  var i = 0;

  $('.addMed').click(function() {
    $("#searchMed").css("display", "block");
  });

  $("#cancelMedoc").click(function() {
    $("#searchMed").css("display", "none");
    $("#medic").val("");
    $("#number").val("");
    $("#period option[value=\"1\"]").prop("selected", true);
    $("#dose").val("");
  })

  var listAllMedic;
  var listMedic = new Array();

  $.ajax({
       url : '/medecin/getMedic.php',
       type: 'GET',
       success: function(ret, statut) {
         listAllMedic = ret;
         for (var i = 0; i < ret.length; i++) {
           listMedic.push(ret[i][1]);
         }
         $("#medic").autocomplete({
           source: listMedic
         });
      $('.ui-autocomplete').css("background-color", "#cdcdcd");
       }
    });

  $("#validMedoc").click(function() {
    if ($("#medic").val() != "" && $("#number").val() != "" && $("#dose").val() != "") {
      var insert = document.getElementById('listMedic');
      var tr = document.createElement('tr');
      var tdName = document.createElement('td');
      var tdFrequency = document.createElement('td');
      var tdPeriod = document.createElement('td');
      var tdDose = document.createElement('td');
      tdName.innerHTML = $("#medic").val();
      tdFrequency.innerHTML = $("#number").val();
      if ($("#period option:selected").val() == 1) {
        tdPeriod.innerHTML = "Par jour";
      } else if ($("#period option:selected").val() == 2) {
        tdPeriod.innerHTML = "Par semaine";
      } else if ($("#period option:selected").val() == 3) {
        tdPeriod.innerHTML = "Par mois";
      }
      tdDose.innerHTML = $("#dose").val();
      tr.appendChild(tdName);
      tr.appendChild(tdFrequency);
      tr.appendChild(tdPeriod);
      tr.appendChild(tdDose);
      insert.appendChild(tr);

      /* Form */
      var form = document.getElementById("listMedicForm");
      var name = document.createElement("input");
      name.type = "hidden";
      name.name = i + "name";
      var idMedic;
      for (var j = 0; j < listMedic.length; j++) {
        if ($("#medic").val() == listAllMedic[j][1]) {
          idMedic = listAllMedic[j][0];
        }
      }
      name.value = idMedic;
      form.appendChild(name);
      var number = document.createElement("input");
      number.type = "hidden";
      number.name = i + "number";
      number.value = $("#number").val();
      form.appendChild(number);
      var period = document.createElement("input");
      period.type = "hidden";
      period.name = i + "period";
      period.value = $("#period option:selected").val();
      form.appendChild(period);
      var dose = document.createElement("input");
      dose.type = "hidden";
      dose.name = i + "dose";
      dose.value = $("#dose").val();
      form.appendChild(dose);
      i++;
      $("#count").val(i);
      $("#searchMed").css("display", "none");
      $("#searchMed").css("display", "none");
      $("#medic").val("");
      $("#number").val("");
      $("#period option[value=\"1\"]").prop("selected", true);
      $("#dose").val("");
    }
  });

  $("#valid").click(function() {
    if ($("#uuid").val != "" && $("#count").val() > 0 && $("#reuse").val() > 0) {
      $("#listMedicForm").submit();
    }
  });
}(jQuery));
