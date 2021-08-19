let img = document.getElementById('article_img');
let img1 = document.getElementById('categorie_img1');
let img2 = document.getElementById('categorie_img2');

let image1 = document.getElementById('carroussel_image1');
let image2 = document.getElementById('carroussel_image2');
let image3 = document.getElementById('carroussel_image3');


if (img1 != null) {
    img1.addEventListener('change', function(e) {
        let text1 = document.getElementById('upload1')
        document.getElementById("labelimg1").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text1.firstChild.data = "uploadé!"
    })

    img2.addEventListener('change', function(e) {
        let text2 = document.getElementById('upload2')
        document.getElementById("labelimg2").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text2.firstChild.data = "uploadé!"
    })
} else if (image1 != null) {
    image1.addEventListener('change', function(e) {
        let text1 = document.getElementById('upload1')
        document.getElementById("labelimg1").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text1.firstChild.data = "uploadé!"
    })

    image2.addEventListener('change', function(e) {
        let text2 = document.getElementById('upload2')
        document.getElementById("labelimg2").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text2.firstChild.data = "uploadé!"
    })
    image3.addEventListener('change', function(e) {
        let text3 = document.getElementById('upload3')
        document.getElementById("labelimg3").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text3.firstChild.data = "uploadé!"
    })
} else {

    img.addEventListener('change', function(e) {
        let text2 = document.getElementById('upload')
        document.getElementById("labelimg").className = "w-64 flex flex-col items-center px-4 py-6 bg-gray-50 text-green-500 rounded-lg shadow-lg tracking-wide uppercase border border-green-500 cursor-pointer";
        text2.firstChild.data = "uploadé!"
    })
}