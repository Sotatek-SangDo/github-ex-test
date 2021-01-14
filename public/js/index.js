/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
console.log(window.Echo);
window.Echo.channel('fork-repository').listen('.finished.fork', function (e) {
  console.log('EHREEEEEEEEEEEE', e);
});
/******/ })()
;