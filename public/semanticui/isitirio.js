
window.isitirio =(function() {

  // menu bar resposive / fixed
  var menuResize = function() {
    var laststate = 0;
    var size = $(window).width()
    if(size <= 750) {
        if(laststate != 1) {
            $("#i_menu").attr('class', 'ui stackable menu');
            $("#i_menu_space").hide();
            laststate = 1;
        }
    }
    else {
       if(laststate != 2) {
           $("#i_menu").attr('class', 'ui top fixed menu');
           $("#i_menu_space").height($("#i_menu").height());

           $("#i_menu_space").show();
           laststate = 2;
       }
    }
  };
  $(window).resize(menuResize);
  menuResize();

  // popup-from initialization
  $("[popup-from]").each(function(index, value){
    var n = $(value);
    var position = "top left";
    var distance = 0;
    if(n.attr("popup-position")) {
      if(n.attr("popup-position")=="dropdown") {
        position = "bottom left";
        distance = -10;
      }
      else {
        position = n.attr("popup-position");
      }
    }
    n.popup({
      on: "click",
      popup: "#" + n.attr("popup-from"),
      position: position,
      distanceAway: distance
    });
  });



  var tmpObj = function() {
    $("body").append('<div id="i_growl_messages" style="position:absolute; z-index:9000; top:5px; right:5px;">');

    this.growl = function (title, message, options) {
      var cssclass = "negative";
      if(options && options.hasOwnProperty('type')) {
        if(options.type=="success" || options.type=="error") {
          cssclass = options.type;
        }
        else if(options.type=="warning" || options.type=="warn") {
          cssclass = "yellow";
        }
        else if(options.type=="information" || options.type=="info") {
          cssclass = "teal";
        }
      }

      var w = $('<div class="ui ' + cssclass + ' message" style="position:relative; top:5px; right:5px;">' +
      '<i class="close icon"></i>' +
      '<div class="header" style="margin-right:10px;">' +
      $("<div>").text(title).html() +
      '</div>' +
      '<p>' +
      $("<div>").text(message).html() +
      '</p></div>');

      $('.close', w).on('click', function() {
        w.transition('fade');
        setTimeout(function() {
          w.remove();
        }, 2000);
      });
      $("#i_growl_messages").append(w);

      if(options && options.hasOwnProperty('timeout')) {
        setTimeout(function() {
          w.transition('fade');
          setTimeout(function() {
            w.remove();
          }, 2000);
        }, options.timeout);
      }

    };
  }
  return new tmpObj();
})();

