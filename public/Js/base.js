



window.onload = function() {
   if (localStorage.getItem("popupShown") === null) {
   document.getElementById("art-info").style.display = "block";
   document.getElementById("close-popup").addEventListener("click", function() {
   document.getElementById("art-info").style.display = "none";
   localStorage.setItem("popupShown", true);
});
} else {
      document.getElementById("art-info").style.display = "none";
   }
};

function logout() {
   localStorage.removeItem('popupShown');
}
