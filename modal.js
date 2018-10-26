
// modal.js

// get modal from 'search.php' or 'searchByProduct.php'
var modal = document.getElementsByClassName('modal');

// get the result box to open modal
var btn = document.getElementsByClassName('imageContainer');

// get 'x' button to close modal
var span = document.getElementById('exitButton');

// open modal when the result box is clicked
btn.onclick = function() {
    modal.style.display = "block";
}

// close modal when the 'x' gets clicked
span.onclick = function() {
    modal.style.display = "none";
}

// when any space outside the modal is clicked, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.sytle.display = "none";
    }
}