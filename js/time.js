var ore = jagservtime.getHours();       // hour
var minute = jagservtime.getMinutes();     // minutes
var secunde = jagservtime.getSeconds();     // seconds

// function that process and display data
function ceas() {
  secunde++;
  if (secunde>59) {
    secunde = 0;
    minute++;
  }
  if (minute>59) {
    minute = 0;
    ore++;
  }
  if (ore>23) {
    ore = 0;
  }
  
  if (secunde<10) {
	ssec = "0"+secunde;
  } else {
	ssec = secunde;
  }

  if (minute<10) {
	smin = "0"+minute;
  } else {
	smin = minute;
  }

  var output = '<b>JAG Time:</b> '+ore+":"+smin+":"+ssec+" <i>WIB</i>";

  document.getElementById("jag_time").innerHTML = output;
}

window.onload = function(){
  setInterval("ceas()", 1000);
}
