
/*
* This three function can show or hide the form to modify a 'sortie'
* This is only accessible for owner of 'sortie' none of this will work if you're not the owner
* */
window.onload = function hideMe() {
    let x = document.getElementById("sectionForm");
    x.style.display = "none";
}


function myFunction() {
    let x = document.getElementById("sectionForm");
    let y = document.getElementById('sectionDetail');
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "none";
    }
}

function retour() {
    let x = document.getElementById("sectionForm");
    let y = document.getElementById('sectionDetail');
    if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
    } else {
        x.style.display = "block";
        y.style.display = "none";
    }
}


