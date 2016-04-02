
function tekst(){
    var p = document.createElement("P");                       
    var dok = document.createTextNode("Witaj");       
    p.appendChild(dok);                                          
    document.body.appendChild(p);
    document.getElementById("struktura").appendChild(p);
}

function kolor() {
    document.bgColor = "red"
}
function kolor1() {
    document.bgColor = "white"
}

function schowaj() {
    document.getElementById('naglowek').style.display = "none";
}
function pokaz() {
    document.getElementById('naglowek').style.display = "block";
}


function licznik() {
if (localStorage.clickcount) {
    localStorage.clickcount = Number(localStorage.clickcount)+1;
} else {
    localStorage.clickcount = 1;
}
document.getElementById("wynik").innerHTML = "Lajki:  " + localStorage.clickcount;
}

function licznik1() {
    if (sessionStorage.clickcount) {
        sessionStorage.clickcount = Number(sessionStorage.clickcount) + 1;
    } else {
        sessionStorage.clickcount = 1;
    }
    document.getElementById("wynik1").innerHTML = "Lajki:  " + sessionStorage.clickcount;
}

