var i = 0;

function addTopic(element) {
  const ul = document.querySelector("ul");
  const numberOfItems = ul.querySelectorAll("li").length;
  const topicsArray = document.getElementById("topicsArray");

  if (numberOfItems < 2) {
    var topicText = element.innerText;
    var listItem = document.createElement("li");
    listItem.setAttribute("name", "topic" + i);
    listItem.setAttribute("value", topicText);
    // listItem.innerText = topicText;

    //Checking if item has already been selected
    var exists = document.querySelector(`li[value = "${topicText}"]`);
    if (exists) {
      /*toast = document.querySelector(".toast");
      close = document.querySelector(".close-icon");
      progress = document.querySelector(".progress");
      
      setTimeout(() => {
        toast.classList.add("active");
        progress.classList.add("active");
  
        setTimeout(() => {
          toast.classList.remove("active");
        }, 5000);
      }, 50);
  
      close.addEventListener("click", () => {
        toast.classList.remove("active");
        progress.classList.remove("active");
      });*/
      toast = document.querySelector(".toast");
      close = document.querySelector(".close-icon");
      progress = document.querySelector(".progress");

      title = document.querySelector(".text-1");
      description = document.querySelector(".text-2");

      title.innerHTML = "Topic Already Selected";
      description.innerHTML = "This topic has already been selected.";

      setTimeout(() => {
        toast.classList.add("active");
        progress.classList.add("active");

        setTimeout(() => {
          toast.classList.remove("active");
          progress.classList.remove("active");
        }, 5000);
      }, 50);

      close.addEventListener("click", () => {
        toast.classList.remove("active");
        progress.classList.remove("active");
      });
      // alert("This topic has already been selected");
      return;
    }

    var pillContainer = document.createElement("div");
    pillContainer.setAttribute("class", "pill " + topicText.toLowerCase());

    var pillSpan = document.createElement("span");
    pillSpan.innerHTML = topicText;

    pillContainer.appendChild(pillSpan);
    listItem.append(pillContainer);
    document.getElementById("selected-topics").appendChild(listItem);

    topicsArray[i] = listItem.innerText;
    topicsArray.value = JSON.stringify(topicsArray);

    i++;
  } else {
    toast = document.querySelector(".toast");
    close = document.querySelector(".close-icon");
    progress = document.querySelector(".progress");

    title = document.querySelector(".text-1");
    description = document.querySelector(".text-2");

    title.innerHTML = "Maximum number of topics selected";
    description.innerHTML = "You may only select between 1 - 2 topic.";

    setTimeout(() => {
      toast.classList.add("active");
      progress.classList.add("active");

      setTimeout(() => {
        toast.classList.remove("active");
        progress.classList.remove("active");
      }, 5000);
    }, 50);

    close.addEventListener("click", () => {
      toast.classList.remove("active");
      progress.classList.remove("active");
    });
    // alert("You can have a maximum of two topics and a minimum of one topic");
  }
}

function removeTopic() {
  const ul = document.querySelector("ul");
  const lastItem = ul.lastElementChild;
  ul.removeChild(lastItem);
  let topicsArray = document.getElementById("topicsArray").value;
  let topics = Object.keys(JSON.parse(topicsArray)).map(
    (key) => JSON.parse(topicsArray)[key]
  );
  topics.pop();
  console.log(topics);

  topicsArray = JSON.stringify(topics);
  document.getElementById("topicsArray").value = topicsArray;
  i--;
}

window.addEventListener("DOMContentLoaded", (event) => {
 
  var continueBtn = document.querySelector("#continue-btn");
  console.log(continueBtn);
  
});

