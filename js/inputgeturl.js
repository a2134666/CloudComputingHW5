function action(){
  if(event.keyCode == 13) {
    var url = document.getElementById('getURL').value;
    window.open(url, "_self");
  }
}  