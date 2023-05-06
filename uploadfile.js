function _(el) {
    return document.getElementById(el);
}

function uploadFile() {
    var file = _("samplefile").files[0];
    var formdata = new FormData();
    formdata.append("samplefile", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "add_signal.php");
    ajax.send(formdata);
}

function progressHandler(event) {
    _("loaded_n_total").innerHTML =
        "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 100;
    document.getElementById("submit").disabled = false;
}

function errorHandler(event) {
    _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";
}

function checkSizeFile(){
    document.getElementById("submit").disabled = true;

    const fi = document.getElementById('samplefile');
    // Check if any file is selected.
    if (fi.files.length > 0) {
        for (const i = 0; i <= fi.files.length - 1; i++) {

            const fsize = fi.files.item(i).size;
            const file = Math.round((fsize / 1024));
            // The size of the file.
            if (file >= 2048) {
                alert("File too Big, please select a file less than 2mb");
                document.getElementById('samplefile').value = "";
                document.getElementById("submit").disabled = false;
            } else {
                uploadFile();
            }
        }
    }
}