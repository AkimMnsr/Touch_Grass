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


