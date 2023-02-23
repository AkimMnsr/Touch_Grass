/*
* this script can save what you write in the form. This is when you want to add lieu and go on another page, when you
* come back, all of you're data be reload on the input
* its working when you cancel you're sortie
* Adding a reset button to refresh the form
*  */

let saveNom;
let saveDate;
let saveCloture;
let savePlace;
let saveDuree;
let saveDescription;

window.onload = function load() {
    saveNom = localStorage.getItem("saveNom");
    saveDate = localStorage.getItem("saveDate");
    saveCloture = localStorage.getItem("saveCloture");
    savePlace = localStorage.getItem("savePlace");
    saveDuree = localStorage.getItem("saveDuree");
    saveDescription = localStorage.getItem("saveDescription");

    document.getElementById("nomSortie").value = saveNom;
    document.getElementById("dateSortie").value = saveDate;
    document.getElementById("dateCloture").value = saveCloture;
    document.getElementById("PlaceId").value = savePlace;
    document.getElementById("DuréeId").value = saveDuree;
    document.getElementById("DescriptionId").value = saveDescription;
}

function save() {
    saveNom = document.getElementById('nomSortie').value;
    saveDate = document.getElementById('dateSortie').value;
    saveCloture = document.getElementById('dateCloture').value;
    savePlace = document.getElementById('PlaceId').value;
    saveDuree = document.getElementById('DuréeId').value;
    saveDescription = document.getElementById('DescriptionId').value;

    localStorage.setItem("saveNom", saveNom);
    localStorage.setItem("saveDate", saveDate);
    localStorage.setItem("saveCloture", saveCloture);
    localStorage.setItem("savePlace", savePlace);
    localStorage.setItem("saveDuree", saveDuree);
    localStorage.setItem("saveDescription", saveDescription);
}

function reset() {
    localStorage.removeItem('saveNom');
    localStorage.removeItem('saveDate');
    localStorage.removeItem('saveCloture');
    localStorage.removeItem('savePlace');
    localStorage.removeItem('saveDuree');
    localStorage.removeItem('saveDescription');
    location.reload();
}


