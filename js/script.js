let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () =>{
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
}

window.onscroll = () =>{
    userBox.classList.remove('active');
    navbar.classList.remove('active');
}

window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    var scrollPosition = window.scrollY;

    // Adjust the scroll position as needed
    var scrollThreshold = 50;

    if (scrollPosition > scrollThreshold) {
       header.classList.add('white-background');
    } else {
       header.classList.remove('white-background');
    }
});

window.addEventListener("scroll", function() {
    var header = document.querySelector(".header");
    if (window.scrollY > 0) {
       header.classList.add("fixed");
    } else {
       header.classList.remove("fixed");
    }
 });




 // Add this script to your existing scripts
 document.addEventListener("DOMContentLoaded", function () {
    var content = document.querySelector('.content');

    function handleScroll() {
       var scrollPosition = window.scrollY;

       if (scrollPosition > 15) {
          content.classList.add('hidden');
       } else {
          content.classList.remove('hidden');
       }
    }

    // Initial check on page load
    handleScroll();

    // Listen for the scroll event
    window.addEventListener("scroll", handleScroll);
 });



 let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}


