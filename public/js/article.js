var mobile;
if (window.width < 481) {
    mobile = 1;
}

if (!mobile) {
    // All your stuff.

    var options1 = {
        zoomWidth: 900,
        offset: { vertical: 0, horizontal: 75 }
    };


    new ImageZoom(document.getElementById("img-container"), options1);

}