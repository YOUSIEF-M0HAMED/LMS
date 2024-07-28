const moreInfoBtn = document.querySelector(".info-shower");
moreInfoBtn.addEventListener("click", function () {
  const moreInfo = document.querySelector(".additional-info");
  moreInfo.classList.toggle("d-none");
  if (moreInfoBtn.innerText === "Show more") {
    moreInfoBtn.innerText = "Show less";
  } else {
    moreInfoBtn.innerText = "Show more";
  }
});

function submitForm() {
  document.getElementById("photoForm-1").submit();
}
