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
    if(exists){
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
      alert("This topic has already been selected");
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
    });
    alert("You can have a maximum of two topics and a minimum of one topic");
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
  // var formEle = document.querySelector("#form1");
  var continueBtn = document.querySelector("#continue-btn");
  console.log(continueBtn);
  // continueBtn.addEventListener("click", (evn) => {
  //   const ul = document.querySelector("ul");
  //   const numberOfItems = ul.querySelectorAll("li").length;
  //   if (numberOfItems <= 0) {
  //     alert("You can have a maximum of two topics and a minimum of 1 topic");
  //     return false;
  //   }
  // });
});

/*
      const topicList = document.querySelectorAll('#selected-topics li');
        let topic1 = null;
        let topic2 = null
        if(topicList.length == 1){
           topic1 = topicList[0].innerText;
        }else if(topicList.length == 2){
           topic1 = topicList[0].innerText;
           topic2 = topicList[1].innerText;
        }
        console.log(topic1);
        console.log(topic2);
        const xh = new XMLHttpRequest();
        const url = "reviewpost.php";
        xh.open("POST",url,true);
        xh.setRequestHeader("Content-Type", "application/json");
        xh.onreadystatechange = function(){
          if(xh.readyState === 4 && xh.status === 200){
            const data = JSON.parse(xh.responseText);
            const topic1 = data.topic1;
            const topic2 = data.topic2;

            window.location.href = "discussion(2).php";
        }else{
            alert(xh.statusText);
        }
        };
        const data = JSON.stringify({topic1: topic1, topic2: topic2});
        xh.send(data);

      */
