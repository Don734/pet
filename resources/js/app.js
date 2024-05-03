import './bootstrap';

import('preline');

// Геолокация пользователя
document.addEventListener("DOMContentLoaded", function() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      // Проверяем, есть ли сохраненные значения в куках или localStorage
      const savedLatitude = localStorage.getItem("latitude");
      const savedLongitude = localStorage.getItem("longitude");

      // Если сохраненных значений нет или они отличаются от текущих, обновляем их
      if (!savedLatitude || !savedLongitude || savedLatitude !== latitude.toString() || savedLongitude !== longitude.toString()) {
        localStorage.setItem("latitude", latitude);
        localStorage.setItem("longitude", longitude);
        window.location.href = "/geolocate-city?latitude=" + latitude + "&longitude=" + longitude;
      }
    }, function(error) {
      console.error("Ошибка получения геолокации: " + error.message);
    });
  }
});

// Слайдер на главной
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    centeredSlides: false,
    grabCursor: true,
    keyboard: {
      enabled: true,
    },
    breakpoints: {
      1024: {
        slidesPerView: 1,
      },
      1280: {
        slidesPerView: 2,
      },
    },
    spaceBetween: 20,
    scrollbar: {
      el: ".swiper-scrollbar",
      draggable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  var script = document.createElement('script');
  script.src = "https://maps.api.2gis.ru/2.0/loader.js";
  document.body.appendChild(script);