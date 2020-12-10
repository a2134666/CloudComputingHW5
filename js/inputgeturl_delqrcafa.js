function action(){
  if(event.keyCode == 13) {
    var url = document.getElementById('getURL').value;
    var res = url.split("http://qrc.afa.gov.tw/blog/");
    var redirectURL = res[1]+'.html';
    window.open(redirectURL, "_self");
  }
}  