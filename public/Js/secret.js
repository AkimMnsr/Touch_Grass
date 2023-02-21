var input = "";
var konami = "38384040373937396665";
document.getElementById('temp').addEventListener("keydown", function (e) {
    input += "" + e.keyCode;
    if (input === konami) {
        window.open("http://127.0.0.1:8000/bored","popup","width=449 height=958 scrollbars=no status=no location=no toolbar=no menubar=no");
        input = "";
    }
    if (!konami.indexOf(input)) return;
    input = "" + e.keyCode;
});


