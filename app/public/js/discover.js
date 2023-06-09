window.addEventListener("DOMContentLoaded", (event) => {
  let topicSliderA = document.querySelector(".topic-slider");
  let topicSlider = $(".topic-slider");
  let slider = document.querySelector(".slider");
  var maxScrollLeft = topicSliderA.scrollWidth - topicSliderA.clientWidth;
  topicSlider.scrollLeft(maxScrollLeft / 2);
  topicSlider.scroll(function () {
    console.log(
      "Scroll Left: " +
        topicSlider.scrollLeft() +
        "Total Width: " +
        maxScrollLeft
    );
    if (topicSlider.scrollLeft() < maxScrollLeft * 0.2) {
      topicSlider.scrollLeft(maxScrollLeft * 0.9);
    } else if (topicSlider.scrollLeft() >= maxScrollLeft * 0.901) {
      topicSlider.scrollLeft(maxScrollLeft * 0.201);
    }
  });

  let isDown = false;
  let startX;
  let scrollLeft;
  topicSliderA.addEventListener("mousedown", (e) => {
    isDown = true;
    topicSliderA.classList.add("active");
    startX = e.pageX - topicSliderA.offsetLeft;
    scrollLeft = topicSliderA.scrollLeft;
  });
  topicSliderA.addEventListener("mouseleave", () => {
    isDown = false;
    topicSliderA.classList.remove("active");
  });
  topicSliderA.addEventListener("mouseup", () => {
    isDown = false;
    topicSliderA.classList.remove("active");
  });
  topicSliderA.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - topicSliderA.offsetLeft;
    const walk = (x - startX) * 3; //scroll-fast
    topicSliderA.scrollLeft = scrollLeft - walk;
    // console.log(walk);
  });

  $("#moveSliderLeftBtn").click(() => {
    moveLeft();
  });
  $("#moveSliderRightBtn").click(() => {
    moveRight();
  });

  function moveLeft() {
    // topicSlider.scrollLeft(topicSlider.scrollLeft() - 500);
    scrollAmount = 0;
    var slideTimer = setInterval(function () {
      topicSliderA.scrollLeft -= 10;
      scrollAmount += 10;
      if (scrollAmount >= 500) {
        window.clearInterval(slideTimer);
      }
    }, 8);
  }

  function moveRight() {
    // topicSlider.scrollLeft(topicSlider.scrollLeft() + 500);
    scrollAmount = 0;
    var slideTimer = setInterval(function () {
      topicSliderA.scrollLeft += 10;
      scrollAmount += 10;
      if (scrollAmount >= 500) {
        window.clearInterval(slideTimer);
      }
    }, 8);
  }
});
