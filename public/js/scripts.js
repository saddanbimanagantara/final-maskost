/*!
 * Start Bootstrap - Shop Homepage v5.0.4 (https://startbootstrap.com/template/shop-homepage)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
 */
// This file is intentionally blank
// Use this file to add JavaScript to your project

var openMobile = document.querySelector(".mobile");
var closeMobile = document.querySelector(".close-mobile");
var navBar = document.querySelector(".navBar");
openMobile.addEventListener("click", () => {
	navBar.classList.add("activeMenu");
});

closeMobile.addEventListener("click", () => {
	navBar.classList.remove("activeMenu");
});
