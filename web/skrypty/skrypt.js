
function tekst(){
    var p = document.createElement('div');                       
    var dok = document.createTextNode("Witaj");       
    p.appendChild(dok);                                          
    document.body.appendChild(p);
    document.getElementById("struktura").appendChild(p);
}

function kolor() {
    document.body.style.backgroundColor = "Khaki ";
}
function kolor1() {
    document.body.style.backgroundColor = "lavender";
}

function schowaj() {
    document.getElementById('naglowek').style.display = "none";
}
function pokaz() {
    document.getElementById('naglowek').style.display = "block";
}

window.onload = function odwiedziny() {
    var storage = window.localStorage;
    if (!storage.pageLoadCount) storage.pageLoadCount = 0;
    storage.pageLoadCount = parseInt(storage.pageLoadCount, 10) + 1;
    document.getElementById('count').innerHTML = storage.pageLoadCount;
    
}
function zegar() {
    var c = window.sessionStorage;
    if (!c.pageLoadCount) c.pageLoadCount = 0;
    c.pageLoadCount = parseInt(c.pageLoadCount, 10) + 1;
    document.getElementById('czas').innerHTML = "Czas spędzony na stronie " + c.pageLoadCount + " sekund";
    c = c + 1;
    setTimeout("zegar()", 1000);
}




