let nightMode = false;

document.getElementById("night-mode").addEventListener("click", () => {
  nightMode =!nightMode;
  if (nightMode) {
    document.body.classList.add("night-mode");
  } else {
    document.body.classList.remove("night-mode");
  }
});

