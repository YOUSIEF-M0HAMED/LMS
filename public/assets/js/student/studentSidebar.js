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
