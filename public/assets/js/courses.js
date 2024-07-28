const btns = document.getElementsByClassName("del-btn");
const coursesContainer = document.getElementsByClassName("courses-container");
const createButton = document.getElementsByClassName("create-btn");
const dropdownMenuButton = document.getElementById("dropdownMenuButton");
const audioRecorderBtn = document.getElementById("btn-audio-recorder");
const msgHolder = document.querySelector(".chat-body");
const viewTabs = document.querySelectorAll(".content-headers a");
let indexDetailsDivClosedBtn = document.createElement("button");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function (e) {
    e.currentTarget.parentElement.parentElement.parentElement.parentElement.remove();
    if (btns.length === 0) {
      coursesContainer[0].remove();
    }
  });
}

let output = document.getElementById("output");
let html = `<div class="col-lg-8 col-sm-12">
                <a href="#" class=""
                  ><h2 class="font-weight-bold">Learn Veu JS</h2></a
                >
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Corporis quod deserunt tenetur cum alias, aut vero ullam
                  voluptas neque necessitatibus eveniet ut optio explicabo
                  pariatur mollitia adipisci corrupti, magni velit.
                </p>
                <div class="mt-2 d-flex justify-content-center">
                  <a href="#" class="btn btn-primary me-2">Visit</a>
                  <a href="#" class="btn btn-secondary me-2">Edit</a>
                  <a href="#" class="btn btn-danger me-2">Delete</a>
                </div>
              </div>`;
// createButton[0].addEventListener("click", function () {
//   output.innerHTML = html;
// });
viewTabs.forEach(function (tab) {
  tab.addEventListener("click", function () {
    dropdownMenuButton.textContent = tab.textContent;
    viewTabs.forEach(function (tab) {
      tab.classList.remove("active");
    });
    tab.classList.add("active");
    if (tab.innerHTML == "Lectures") {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
        });
      document
        .querySelectorAll(".container > .content-details > div")[0]
        .classList.remove("d-none");
    } else if (tab.innerHTML == "Assignments") {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
        });
      document
        .querySelectorAll(".container > .content-details > div")[1]
        .classList.remove("d-none");
    } else {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
        });
      document
        .querySelectorAll(".container > .content-details > div")[2]
        .classList.remove("d-none");
    }
  });
});

viewTabs.forEach(function (tab) {
  tab.addEventListener("click", function () {
    viewTabs.forEach(function (tab) {
      tab.classList.remove("active");
    });
    tab.classList.add("active");
    if (tab.innerHTML == "Lectures") {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
          ele.classList.remove("d-flex");
        });
      document
        .querySelectorAll(".container > .content-details > div")[0]
        .classList.remove("d-none");
      document
        .querySelectorAll(".container > .content-details > div")[0]
        .classList.add("d-flex");
    } else if (tab.innerHTML == "Assignments") {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
          ele.classList.remove("d-flex");
        });
      document
        .querySelectorAll(".container > .content-details > div")[1]
        .classList.remove("d-none");
      document
        .querySelectorAll(".container > .content-details > div")[1]
        .classList.add("d-flex");
    } else {
      document
        .querySelectorAll(".container > .content-details > div")
        .forEach(function (ele) {
          ele.classList.add("d-none");
          ele.classList.remove("d-flex");
        });
      document
        .querySelectorAll(".container > .content-details > div")[2]
        .classList.remove("d-none");
      document
        .querySelectorAll(".container > .content-details > div")[2]
        .classList.add("d-flex");
    }
  });
});

let videos = document.querySelectorAll(".videoLink");
videos.forEach(function (video) {
  video.addEventListener("click", function (event) {
    event.preventDefault();
    let newVideo = document.createElement("video");
    newVideo.style.cssText = "width:100%; height:100%;";
    newVideo.setAttribute("controls", "true");
    newVideo.innerHTML = `<source src="${video.getAttribute(
      "href"
    )}" type="video/mp4">`;
    indexDetailsDivClosedBtn.classList.add("btn-close");
    indexDetailsDivClosedBtn.classList.add("bg-danger");
    indexDetailsDivClosedBtn.classList.add("col-2");
    indexDetailsDivClosedBtn.setAttribute("type", "submit");
    document.querySelector(".d-flex > .index-details").innerHTML = "";
    document
      .querySelector(".d-flex > .index-details")
      .appendChild(indexDetailsDivClosedBtn);
    document.querySelector(".d-flex  .index-details").appendChild(newVideo);
  });
});

let images = document.querySelectorAll(".imageLink");
images.forEach(function (image) {
  image.addEventListener("click", function (event) {
    event.preventDefault();
    let newImage = document.createElement("img");
    newImage.style.cssText = "width:100%; height:100%;";
    newImage.setAttribute("src", image.getAttribute("href"));
    indexDetailsDivClosedBtn.classList.add("btn-close");
    indexDetailsDivClosedBtn.classList.add("bg-danger");
    indexDetailsDivClosedBtn.classList.add("col-2");
    indexDetailsDivClosedBtn.setAttribute("type", "submit");
    document.querySelector(".d-flex  .index-details").innerHTML = "";
    document
      .querySelector(".d-flex > .index-details")
      .appendChild(indexDetailsDivClosedBtn);
    document.querySelector(".d-flex  .index-details").appendChild(newImage);
  });
});

let files = document.querySelectorAll(".fileLink");
files.forEach(function (file) {
  file.addEventListener("click", function (event) {
    event.preventDefault();
    let iframe = document.createElement("iframe");
    iframe.setAttribute("width", "100%");
    iframe.setAttribute("height", "100%");
    iframe.setAttribute("src", file.getAttribute("href"));
    indexDetailsDivClosedBtn;
    indexDetailsDivClosedBtn.classList.add("btn-close");
    indexDetailsDivClosedBtn.classList.add("bg-danger");
    indexDetailsDivClosedBtn.classList.add("col-2");
    indexDetailsDivClosedBtn.setAttribute("type", "submit");
    document.querySelector(".d-flex  .index-details").innerHTML = "";
    document
      .querySelector(".d-flex  .index-details")
      .appendChild(indexDetailsDivClosedBtn);
    document.querySelector(".d-flex  .index-details").appendChild(iframe);
  });
});

indexDetailsDivClosedBtn.addEventListener("click", function () {
  document.querySelector(".d-flex  .index-details").innerHTML = "";
});
window.addEventListener("DOMContentLoaded", function () {
  let chatContainer = document.querySelector(".chat-body");
  chatContainer.scrollTop = chatContainer.scrollHeight;
});
