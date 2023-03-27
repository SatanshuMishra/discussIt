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
    alert("You can have a maximum of two topics and a minimum of 1 topic");
  }
}

function removeTopic() {
  const ul = document.querySelector("ul");
  const lastItem = ul.lastElementChild;
  ul.removeChild(lastItem);
  i--;
}

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
