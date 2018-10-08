// 
// modal.js
//

var slideIndex = 1;

// reveal modal div
function openModal() {
    // block may not be the best way to dislay
    // consider flex or something 
    var items = document.getElementsByClassName('modal');
    for (var i = 0; i < items.length; i++) {
        items[i].style.display = 'block';
    } 
    
    showSlides(slideIndex);
}

// close modal
function closeModal() {
    document.getElementsByClassName('modal').style.display = 'none';
}

// next/prev buttons
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName('modal');
    var text = document.getElementsByClassName('text');
    // slide cycle
    if (n > slideIndex) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    // hide all slides init
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    // show current slide
    // - 1 because array is 0-based 
    slides[slideIndex - 1].style.display = 'block';
    // get details/product info text for slide
    text.innerHTML = slides[slideIndex - 1].getElementsByClassName('text');
}