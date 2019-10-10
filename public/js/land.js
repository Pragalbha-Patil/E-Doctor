document.addEventListener("DOMContentLoaded", function() {
  const introText = document.getElementsByClassName('intro__text'),
  introBtn = document.getElementsByClassName('intro__btn');
  
  // introBtn[0].addEventListener('click', () => alert('Click on the doctor icon to get started'));
  
  setTimeout(()=> {
    introText[0].classList.add('start');
    introBtn[0].classList.add('start');
  }, 800);
});