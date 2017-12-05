(function() {
  $("#cancel").click(function() {
    $("#searchMed").css("display", "none");
  })

  $("#validUUID").click(function() {
    if ($("#uuidInp").val() != "")
    {
      $.ajax({
        url : '/pharmacien/getOrdo.php',
        type : 'POST',
        data : 'uuid=' + $("#uuidInp").val(),
        dataType : 'html',
        success : function(rep, stat) {
          if (rep != "" && rep != "ko") {
            $("#searchMed").css("display", "block");
            var insert = document.getElementById("ordoListDisp");
            insert.innerHTML = "";
            var ret = JSON.parse(rep);
            if (ret.length == 0) {
              var value = document.createElement("p");
              value.id = "-1";
              value.style.textAlign = "center";
              value.innerHTML = "Aucune ordonance créée";
              insert.appendChild(value);
            }
            else {
              for (var i = 0; i < ret.length; i++) {
                var value = document.createElement("p");
                value.className = "valueOrdoList";
                value.id = ret[i]["id"];
                value.innerHTML = 'Par ' + ret[i]["name"] + ' le ' + ret[i]["date"];
                insert.appendChild(value);
              }
            }
            $(".valueOrdoList").click(function() {
              console.log($(this).attr("id"));
              window.location = "/show-ordo-" + $(this).attr("id");
            });
          }
          else {
            alert("Une erreur c'est produite");
          }
        }
      });
    }
  });
} (jQuery));
