//----------------------BACKGROUND PARALLAXE----------------------//

if ((document.querySelector("title").innerHTML = "Accueil")) {
  const image2El = document.querySelector(".image2");
  const image3El = document.querySelector(".image3");
  const image4El = document.querySelector(".image4");
  const image5El = document.querySelector(".image5");
  const image6El = document.querySelector(".image6");

  window.addEventListener("scroll", function () {
    let value = window.scrollY;

    image2El.style.bottom = value * 0.15 + -4 * 16 + "px";
    image3El.style.top = value * 0.5 + 3 * 16 + "px";
    image4El.style.bottom = value * 0.1 + -8 * 16 + "px";
    image5El.style.bottom = value * 0.3 + -8 * 16 + "px";
    image6El.style.bottom = -(value * 0.25) + "px";
  });
}
//----------------------CONNEXION AFFICHAGE----------------------//

const rows = 3;
const columns = 3;

let currentTile;
let otherTile;
let has_right = false;

const button = document.getElementById("submit-button");
const buttonIcon = document.getElementById("submit-icon");

const blurEl = document.querySelector(".blur-el");
const loginAccountEl = document.querySelector(".loginAccount-el");
const createAccountEl = document.querySelector(".createAccount-el");
const passwordAccountEl = document.querySelector(".passwordAccount-el");
const backgroundEl = document.querySelector(".background");
const bodyEl = document.querySelector("body");

function login() {
  blurEl.style.filter = "blur(5px)";
  createAccountEl.removeAttribute("style");
  passwordAccountEl.removeAttribute("style");
  loginAccountEl.style.display = "block";
  cleanPuzzle();
}

function createAccount() {
  loginAccountEl.removeAttribute("style");
  passwordAccountEl.removeAttribute("style");
  createAccountEl.style.display = "block";
  generatePuzzle();
  has_right = false;
}

function passwordAccount() {
  loginAccountEl.removeAttribute("style");
  createAccountEl.removeAttribute("style");
  passwordAccountEl.style.display = "block";
  cleanPuzzle();
}

function fermer() {
  loginAccountEl.removeAttribute("style");
  createAccountEl.removeAttribute("style");
  passwordAccountEl.removeAttribute("style");
  blurEl.style.filter = "blur(0)";
  cleanPuzzle();
}
//----------------------CONNEXION AFFICHAGE----------------------//

//----------------------CAPTCHA PUZZLE----------------------//
function shuffleArray(arr) {
  arr.sort(() => Math.random() - 0.5);
}

function generatePuzzle() {
  let arrayPuzzle = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
  shuffleArray(arrayPuzzle);

  for (let i = 0; i < rows; i++) {
    for (let j = 0; j < columns; j++) {
      let tile = document.createElement("img");
      tile.id = i.toString() + "-" + j.toString();
      tile.src = "puzzle/" + arrayPuzzle.shift() + ".png";
      document.getElementById("board").appendChild(tile);

      tile.addEventListener("dragstart", dragStart);
      tile.addEventListener("dragover", dragOver);
      tile.addEventListener("dragenter", dragEnter);
      tile.addEventListener("dragleave", dragLeave);
      tile.addEventListener("drop", dragDrop);
      tile.addEventListener("dragend", dragEnd);
    }
  }
}

function dragStart() {
  currentTile = this;
}

function dragOver(e) {
  e.preventDefault();
}

function dragEnter(e) {
  e.preventDefault();
}

function dragLeave() {}

function dragDrop() {
  otherTile = this;
}

function dragEnd() {
  let currentImg = currentTile.src;
  let otherImg = otherTile.src;

  currentTile.src = otherImg;
  otherTile.src = currentImg;

  verificationAll();
}

function cleanPuzzle() {
  document.getElementById("board").innerHTML = "";
}
//----------------------CAPTCHA PUZZLE----------------------//

//----------------------FRONT-END VERIFICATIONS----------------------//

//regex//
const mail_format =
  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const password_format =
  /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{5,}$/;

const inputsEl = document.querySelectorAll(".input-verification");

inputsEl.forEach((e) => {
  e.addEventListener("change", verificationAll)
});

function verificationAll(){
  if (loginAccountEl.hasAttribute("style")) {
    if (
      emailVerification("login") &&
      document.querySelector(".password-el-login").value != ""
    ) {
      has_right = true;
      isValidate("login");
    } else {
      isNotValidate("login");
    }
  }
  if (createAccountEl.hasAttribute("style")) {
    if (
      emailVerification("create") &&
      passwordVerification("create") &&
      rePasswordVerification() &&
      captchaVerification()
    ) {
      has_right = true;
      isValidate("create");
    } else {
      isNotValidate("create");
    }
  }
  if (passwordAccountEl.hasAttribute("style")) {
    if (emailVerification("password")) {
      has_right = true;
      isValidate("password");
    } else {
      isNotValidate("password");
    }
  }
}
function emailVerification(classInput) {
  if (
    mail_format.test(document.querySelector(".email-el-" + classInput).value)
  ) {
    return true;
  }
  return false;
}

function passwordVerification(classInput) {
  if (
    password_format.test(
      document.querySelector(".password-el-" + classInput).value
    )
  ) {
    return true;
  }
  return false;
}

function rePasswordVerification() {
  if (
    document.querySelector(".password-el-create").value !=
    document.querySelector(".rePassword-el-create").value
  ) {
    return false;
  }
  return true;
}

function captchaVerification() {
  if (
    document.getElementById("0-0").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/1.png" &&
    document.getElementById("0-1").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/2.png" &&
    document.getElementById("0-2").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/3.png" &&
    document.getElementById("1-0").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/4.png" &&
    document.getElementById("1-1").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/5.png" &&
    document.getElementById("1-2").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/6.png" &&
    document.getElementById("2-0").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/7.png" &&
    document.getElementById("2-1").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/8.png" &&
    document.getElementById("2-2").src ==
      "http://localhost:81/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/9.png"
  ) {
    return true;
  }
  return false;
}

function isValidate(classInput) {

  document
    .getElementById("submit-button-" + classInput)
    .setAttribute("type", "submit");
  document.getElementById("submit-button-" + classInput).className =
    "form-submit-yes";
  document.getElementById("submit-button-" + classInput).style.transform =
    "rotate(360deg)";
  setTimeout(function () {
    document.getElementById("submit-icon-" + classInput).className =
      "fa-solid fa-check";
  }, 200);
}

function isNotValidate(classInput) {
  if (
    document.getElementById("submit-button-" + classInput).hasAttribute("type")
  ) {
    document
      .getElementById("submit-button-" + classInput)
      .removeAttribute("type");
  }
  document.getElementById("submit-button-" + classInput).className =
    "form-submit-no";
  if (has_right) {
    document.getElementById("submit-button-" + classInput).style.transform =
      "rotate(-360deg)";
  }

  setTimeout(function () {
    document.getElementById("submit-icon-" + classInput).className =
      "fa-solid fa-xmark";
  }, 200);
}

//----------------------FRONT-END VERIFICATIONS----------------------//
