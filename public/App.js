const navbarMenu = document.getElementById("menu");
const burgerMenu = document.getElementById("burger");
const headerMenu = document.getElementById("header");
const overlayMenu = document.querySelector(".overlay");

// Open Close Navbar Menu on Click Burger

burgerMenu.addEventListener("click", () => {
   burgerMenu.classList.toggle("is-active");
   navbarMenu.classList.toggle("is-active");
});


// Close Navbar Menu on Click Links
document.querySelectorAll(".menu-link").forEach((link) => {
   link.addEventListener("click", () => {
      burgerMenu.classList.remove("is-active");
      navbarMenu.classList.remove("is-active");
   });
});

// Fixed Navbar Menu on Window Resize
window.addEventListener("resize", () => {
   if (window.innerWidth >= 992) {
      if (navbarMenu.classList.contains("is-active")) {
         navbarMenu.classList.remove("is-active");
         overlayMenu.classList.remove("is-active");
      }
   }
});

const onChangBackGroundColorChangeTextColor = ( currentTheme ) => {
   
   document.getElementById("header").classList.toggle("darkmode", currentTheme === "enabled");
   document.getElementById("menu").classList.toggle("darkmode", currentTheme === "enabled");
   
   const burger = document.getElementsByClassName("burger-line");
   for (let i = 0; i < burger.length; i++) {
      burger[i].style.backgroundColor = currentTheme === "enabled" ? "#fff" : "#333";
   }

   const links = document.getElementsByClassName("menu-link");
   for (let i = 0; i < links.length; i++) {
      links[i].style.color = currentTheme === "enabled" ? "#fff" : "#333";
   }
   document.getElementById("HomeAppName").style.color = currentTheme === "enabled" ? "#fff" : "#333";
   document.getElementById("SunnyIcon").style.color = currentTheme === "enabled" ? "#fff" : "#333";
   document.getElementById("MoonIcon").style.color = currentTheme === "enabled" ? "#fff" : "#333";
};

// Dark and Light Mode on Switch Click
document.addEventListener("DOMContentLoaded", () => {
   const darkSwitch = document.getElementById("switch");

   const currentTheme = localStorage.getItem("darkmode");

   if (currentTheme) {
      document.documentElement.classList.toggle("darkmode", currentTheme === "enabled");
      document.body.classList.toggle("darkmode", currentTheme === "enabled");
      document.getElementById('SunnyIcon').name = 'moon-outline';

      onChangBackGroundColorChangeTextColor( currentTheme );

   }


   darkSwitch.addEventListener("click", () => {
      document.documentElement.classList.toggle("darkmode");
      document.body.classList.toggle("darkmode");

      if (document.documentElement.classList.contains("darkmode")) {

         localStorage.setItem("darkmode", "enabled");
         document.getElementById('SunnyIcon').name = 'moon-outline';

         onChangBackGroundColorChangeTextColor( "enabled" );

      } else {
         localStorage.setItem("darkmode", "disabled");
         document.getElementById('SunnyIcon').name = 'sunny-outline';

         onChangBackGroundColorChangeTextColor( "disabled" );
      }

   });
});

