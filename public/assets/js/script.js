const btnOpen = document.querySelector("#btn-open-sidebar");
const btnClose = document.querySelector("#btn-close-sidebar");
const myLayoutPage = document.querySelector(
  ".layout-container .content-wrapper"
);
const mySidebar = document.querySelector(".layout-container .layout-menu");
const mySearchButton = document.querySelector(".search-button");
const mySearchInput = document.querySelector(".search-input");
const myCloseIconInput = document.querySelector(".close-icon-input");
const colorModesList = document.querySelector("#color-modes");
const colorModesItems = colorModesList.querySelectorAll("ul > li");
const LanguagesList = document.querySelector("#languages");
const languageItems = LanguagesList.querySelectorAll("ul > li");
const pageText = document.body.innerText;
const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]+/;

if (arabicRegex.test(pageText)) {
  languageItems[0].firstElementChild.classList.remove("active");
  languageItems[1].firstElementChild.classList.add("active");
} else {
  languageItems[0].firstElementChild.classList.add("active");
  languageItems[1].firstElementChild.classList.remove("active");
}
colorModesItems.forEach(function (item) {
  item.addEventListener("click", function () {
    colorModesItems.forEach(function (ele) {
      ele.firstElementChild.classList.remove("active");
    });
    item.firstElementChild.classList.add("active");
  });
});
myLayoutPage.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.remove("active");
  document
    .querySelector(".layout-container .layout-menu .sidebar-logo")
    .classList.remove("active");
  btnClose.classList.remove("active");
  myLayoutPage.classList.remove("overlay");
  document.body.style.overflow = "visible";
});
btnOpen.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.add("active");
  document
    .querySelector(".layout-container .layout-menu .sidebar-logo")
    .classList.add("active");
  btnClose.classList.add("active");
  myLayoutPage.classList.add("overlay");
  document.body.style.overflow = "hidden";
});

mySidebar.addEventListener("mouseover", function () {
  document.body.style.overflowY = "hidden";
});

mySidebar.addEventListener("mouseout", function () {
  if (!myLayoutPage.classList.contains("overlay")) {
    document.body.style.overflowY = "auto";
  }
});

btnClose.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.remove("active");
  document
    .querySelector(".layout-container .layout-menu .sidebar-logo")
    .classList.remove("active");
  this.classList.remove("active");
  myLayoutPage.classList.remove("overlay");
  document.body.style.overflow = "visible";
});

document.querySelectorAll(".main-item").forEach(function (item) {
  item.addEventListener("click", function () {
    document.querySelectorAll(".main-item").forEach(function (ele) {
      ele.classList.remove("active");
    });
    item.classList.add("active");
    localStorage.setItem("activeMainItemID", item.id);
  });
});

document.querySelectorAll(".sub-item").forEach(function (item) {
  item.addEventListener("click", function () {
    document.querySelectorAll(".sub-item").forEach(function (ele) {
      ele.classList.remove("active");
    });
    if (
      !document.querySelector(
        ".layout-container .layout-menu .sidebar-nav .sidebar-item .fa-circle"
      ) === null
    ) {
      document
        .querySelector(
          ".layout-container .layout-menu .sidebar-nav .sidebar-item .fa-circle"
        )
        .classList.remove("text-light");
      document
        .querySelectorAll(
          ".layout-container .layout-menu .sidebar-nav .sidebar-item .fa-circle"
        )
        .forEach(function (ele) {
          ele.classList.remove("active");
        });
    }

    item.classList.add("active");
    localStorage.setItem("activeElementID", item.id);
    item.firstElementChild.classList.add("active");
  });
});

mySearchButton.addEventListener("click", function () {
  mySearchInput.focus();
  mySearchInput.classList.remove("d-none");
  mySearchInput.classList.add("active");
  myCloseIconInput.classList.add("active");
});

mySearchInput.addEventListener("blur", function () {
  mySearchInput.classList.add("d-none");
  mySearchInput.classList.remove("active");
  myCloseIconInput.classList.remove("active");
  mySearchInput.value = "";
});
document.body.addEventListener("click", function (event) {
  var clickedElement = event.target;

  if (!clickedElement.closest(".layout-navbar .user-settings > li")) {
    document
      .querySelectorAll(".layout-navbar .user-settings > li > ul")
      .forEach(function (ul) {
        ul.classList.remove("active");
      });
  }
});
document
  .querySelectorAll(".layout-navbar .user-settings > li")
  .forEach(function (li) {
    li.addEventListener("click", function () {
      if (li.querySelector("ul:last-child").classList.contains("active")) {
        li.querySelector("ul:last-child").classList.remove("active");
      } else {
        document
          .querySelectorAll(".layout-navbar .user-settings > li > ul")
          .forEach(function (ul) {
            ul.classList.remove("active");
          });
        li.querySelector("ul:last-child").classList.add("active");
      }
    });
  });

document
  .querySelectorAll(".layout-navbar .user-settings > li > ul > li a")
  .forEach(function (a) {
    a.addEventListener("mousedown", function () {
      this.classList.add("active");
    });
    a.addEventListener("mouseup", function () {
      this.classList.remove("active");
    });
  });

document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    let activeMainItemId = localStorage.getItem("activeMainItemID");
    let activeSubItemId = localStorage.getItem("activeElementID");
    if (activeMainItemId) {
      let activeMainItem = document.getElementById(activeMainItemId);
      let activeMainItemMenuID = activeMainItem.getAttribute("aria-controls");
      let activeMainItemMenu = document.getElementById(activeMainItemMenuID);
      if (activeMainItem) {
        document.querySelectorAll(".main-item").forEach(function (ele) {
          ele.classList.remove("active");
        });
        activeMainItem.classList.add("active");
        activeMainItemMenu.classList.add("show");
        activeMainItem.classList.remove("collapsed");
      }
    }
    if (activeSubItemId) {
      // Find the element with the stored id and add the "active" class
      let activeSubItem = document.getElementById(activeSubItemId);
      if (activeSubItem) {
        document.querySelectorAll(".sub-item").forEach(function (ele) {
          ele.classList.remove("active");
        });
        if (
          !document.querySelector(
            ".layout-container .layout-menu .sidebar-nav .sidebar-item .fa-circle"
          ) === null
        ) {
          document
            .querySelectorAll(
              ".layout-container .layout-menu .sidebar-nav .sidebar-item .fa-circle.active"
            )
            .forEach(function (ele) {
              ele.classList.remove("active");
            });
        }
        activeSubItem.classList.add("active");
        activeSubItem.firstElementChild.classList.add("active");
      }
    } else {
      document.querySelector(".first-sub-item").classList.add("active");
      document
        .querySelector(".first-sub-item")
        .firstElementChild.classList.add("active");
    }
  }, 100);
});
