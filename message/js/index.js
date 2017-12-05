(function() {
  var claerResizeScroll, conf, getRandomInt, insertI, lol;

  conf = {
    cursorcolor: "#696c75",
    cursorwidth: "4px",
    cursorborder: "none"
  };

  lol = {
    cursorcolor: "#cdd2d6",
    cursorwidth: "4px",
    cursorborder: "none"
  };

var ret;
var oldLength = 0;
var chatSelect = 0;
var idSelect = -1;

  getMessage = function() {
    $.post (
      '/message/getMessage.php',
      null,
      function(res){
        ret = JSON.parse(res);
        if (ret.length != 0) {
          if (idSelect == -1) {
            idSelect = ret[0]["id"];
          }
          for (i = 0; i < ret.length; i++) {
            if (idSelect == ret[i]["id"]) {
              chatSelect = i;
              break;
            }
          }
          /* Liste des contacts */
          $(".list-friends").html("");
          var menuInsert = document.getElementById('list-friends');
          for (i = 0; i < ret.length; i++) {
            var list = document.createElement('li');
                if (i == chatSelect) {
                  list.className += "selected ";
                }
                list.style.cursor = 'pointer';
                list.id = ret[i]["id"];
                list.className += "user-list";
            var divHead = document.createElement('div');
                divHead.className += "info";
            var img = document.createElement('img');
                img.width = "50";
                img.height = "50";
                img.src = "/images/avatar.jpg";
            var divUser = document.createElement('div');
                divUser.className = "user";
                divUser.innerHTML = ret[i]["name"];
            var divStat = document.createElement('div');
                divStat.className = "status on";
                divStat.innerHTML = " " + ret[i]["message"].length + " messages";
            list.appendChild(img);
            divHead.appendChild(divUser);
            divHead.appendChild(divStat);
            list.appendChild(divHead);
            menuInsert.appendChild(list);
          }
          $(".user-list").click(function(){
            $(".selected").removeClass("selected");
            $(this).addClass("selected");
            idSelect = $(this).attr("id");
            getMessage();
          });

          /* Affichage des messages */
          $(".messages").html("");
          $(".info .name").html(ret[chatSelect]["name"]);
          if (ret[chatSelect]["message"].length < 2) {
              $(".info .count").html(ret[chatSelect]["message"].length + " message");
          } else {
              $(".info .count").html(ret[chatSelect]["message"].length + " messages");
          }
          for (i = 0 ; i < ret[chatSelect]["message"].length; i++) {
            if (ret[chatSelect]["message"][i]["type"] == 1)
              $(".messages").append("<li class=\"i\"><div class=\"head\"><span class=\"time\">" + ret[chatSelect]["message"][i]["date"] + "</span><span class=\"name\"> Moi</span></div><div class=\"message\">" + decodeURI(ret[chatSelect]["message"][i]["msg"]) + "</div></li>");
            else
              $(".messages").append("<li class=\"friend-with-a-SVAGina\"><div class=\"head\"><span class=\"name\">" + ret[chatSelect]["name"] + "  </span><span class=\"time\">" + ret[chatSelect]["message"][i]["date"] + "</span></div><div class=\"message\">" + decodeURI(ret[chatSelect]["message"][i]["msg"]) + "</div></li>");
          }
          if (oldLength != ret[chatSelect]["message"].length) {
              $(".messages").scrollTop(10000000);
              oldLength = ret[chatSelect]["message"].length;
          }
        }
      },
      'text'
    );
  };

  getRandomInt = function(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  claerResizeScroll = function() {
    $("#texxt").val("");
    $(".messages").getNiceScroll(0).resize();
    return $(".messages").getNiceScroll(0).doScrollTop(999999, 999);
  };

  insertI = function() {
    var innerText, otvet;
    innerText = $.trim($("#texxt").val());
    if (innerText !== "") {
      $.post (
        '/message/postMessage.php',
        {
          id: ret[chatSelect]["id"],
          msg: encodeURI(innerText)
        },
        function(res){
          if (res == "ko") {
            alert("Un problème a eu lieu")
          }
        },
        'text'
      );
      claerResizeScroll();
      return otvet = setInterval(function() {
        claerResizeScroll();
        return clearInterval(otvet);
      }, getRandomInt(2500, 500));
    }
  };

  $(document).ready(function() {
    getMessage();
    setInterval(getMessage, 2000);
    $(".list-friends").niceScroll(conf);
    $(".messages").niceScroll(lol);
    $("#texxt").keypress(function(e) {
      if (e.keyCode === 13) {
        insertI();
        return false;
      }
    });
    return $(".send").click(function() {
      return insertI();
    });
  });

}).call(this);
