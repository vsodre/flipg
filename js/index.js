function looseTime() {
  var d = new Date();
  var h = d.getHours();
  //  if (h>12) {h=h-12}
  function hours12(date) { return (date.getHours() + 24) % 12 || 12; }
  var hour = new Array(12);
  hour[1] = "one";
  hour[2] = "two";
  hour[3] = "three";
  hour[4] = "four";
  hour[5] = "five";
  hour[6] = "six";
  hour[7] = "seven";
  hour[8] = "eight";
  hour[9] = "nine";
  hour[10] = "ten";
  hour[11] = "eleven";
  hour[12] = "twelve";
  var hours = hour[hours12(d)];
  var hourplus = hour[hours12(d)+1];
  var report;
  var m = d.getMinutes();

  if (m < 10) {
    report = "just after " + hours;
  } else if (m >= 10 && m < 20) {
    report = "quarter past " + hours;
  } else if (m >= 20 && m < 30) {
    report = "heading for half " + hours;
  } else if (m >= 30 && m < 40) {
    report = "just gone half " + hours;
  } else if (m >= 40 && m < 50) {
    report = "quarter to " + hourplus;
  } else if (m >= 50) {
    report = "getting on for " + hourplus;
  }
  document.getElementById("fuzzytime").innerHTML= report;
}
var doit = setInterval(function(){looseTime()}, 60000);
jQuery.ajax({
  url: 'http://api.openweathermap.org/data/2.5/weather?q=Cambridge,UK&units=metric&APPID=48fa395ba290ba63613f94c639dced4a',
  jsonp: 'callback',
  dataType: 'jsonp',
  cache: false,

  success: function (response) {
    jQuery('#weather-name').text(response.name);
    jQuery('#weather-description').text('Outlook: ' + response.weather[0].description);
    jQuery('#weather-temp').text('Temp: ' + response.main.temp + ' \u00B0\C');
    jQuery('#weather-wind').text('Windspeed: ' + response.wind.speed + ' kph');
  },
});

jQuery.ajax({
  url: 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&rsz=8&q=javascript',
  jsonp: 'callback',
  dataType: 'jsonp',
  cache: false,

  success: function (data) {
    jQuery(data.responseData.results).each(function (index, entry) {
      var newsitem = '<li><a href="' + entry.url + '">' + entry.titleNoFormatting + '</a></li>';
       jQuery('#news').append(newsitem);
    });
    jQuery.mark.rotate('#news');
  },
});


(function (jQuery) {
  jQuery.mark = {
    rotate: function (options) {
      var defaults = {
        selector: '.rotate'
      };

      if (typeof options == 'string') defaults.selector = options;
      var options = jQuery.extend(defaults, options);
      return jQuery(options.selector).each(function () {
        var obj = jQuery(this);

        if(obj.attr("data-timing")) {
          var pause = obj.attr( "data-timing" );
        } else {
          pause = '5000';
        }

        if(obj.attr("data-pause")) {
          var delay = obj.attr( "data-pause" );
        } else {
          delay = '0';
        }

        var length = jQuery(obj).children().length;
        var temp = 0;

        function show() {
          temp = (temp == length) ? 1 : temp + 1
          jQuery(obj).children().hide();
          jQuery(':nth-child(' + temp + ')', obj).fadeIn('slow')
        };

        function init() {
          show();
          var megap = setInterval(show, pause);
          obj.hover(function () {
            clearInterval(megap);
          }, function () {
            megap = setInterval(show, pause);
          });
        };
        setTimeout(init, delay);

      })
    }
  }
})(jQuery);


jQuery(function(){	
  jQuery.mark.rotate();
});
