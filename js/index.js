//----------------------BACKGROUND PARALLAXE----------------------//

if (document.querySelector("title").innerHTML == "Accueil") {
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
  cleanPuzzle();
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

if((window.location.href).indexOf('?') != -1) {
  let queryString = (window.location.href).substr((window.location.href).indexOf('?') + 1); 

  let value = (queryString.split('&'))[0];

  value = decodeURIComponent(value);
  
  if(
    value == "message_connection=Identifiants incorrects." ||
    value == "message_connection=Le compte associé à cet email est banni."){
    login();
  }
  if(
    value == "message_createAccount=Email invalide." || 
    value == "message_createAccount=Le compte associé à cet email est banni." || 
    value == "message_createAccount=Email déjà utilisé." ||
    value == "message_createAccount=Pseudo déjà utilisé"){
    createAccount;
  }
  if(value == "message_password=Identifiants incorrects."){
    login();
  }
  
}
//----------------------CONNEXION AFFICHAGE----------------------//

//----------------------CAPTCHA PUZZLE----------------------//
function shuffleArray(arr) {
  arr.sort(() => Math.random() - 0.5);
}

if (createAccountEl != null) {
  cleanPuzzle();
  generatePuzzle();
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

  captchaVerification();
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
  e.addEventListener("keyup", verificationAll);
});

function verificationAll() {
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
      document.querySelector(".nickname-el-create").value !== "" &&
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
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/1.png" &&
    document.getElementById("0-1").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/2.png" &&
    document.getElementById("0-2").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/3.png" &&
    document.getElementById("1-0").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/4.png" &&
    document.getElementById("1-1").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/5.png" &&
    document.getElementById("1-2").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/6.png" &&
    document.getElementById("2-0").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/7.png" &&
    document.getElementById("2-1").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/8.png" &&
    document.getElementById("2-2").src ==
      "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/puzzle/9.png"
  ) {
    document.querySelector("#board").style.borderColor = "#3bac29";
    return true;
  }
  document.querySelector("#board").style.borderColor = "#ff1515";
  return false;
}

function isValidate(classInput) {
  document
    .getElementById("submit-button-" + classInput)
    .setAttribute("type", "submit");
  document.getElementById("submit-button-" + classInput).className =
    "form-submit-yes";
  document
    .getElementById("submit-button-" + classInput)
    .removeAttribute("disabled");
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
  document
    .getElementById("submit-button-" + classInput)
    .setAttribute("disabled", "");
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

//-------------------------INDICATIONS PASSWORD-------------------------//

//VARIABLES//

const constatEl = document.querySelector("#constat");
const constatUpperEl = document.querySelector("#constat_upper");
const constatLowerEl = document.querySelector("#constat_lower");
const constatNumberEl = document.querySelector("#constat_number");
const constatSpecialEl = document.querySelector("#constat_special");
const constatFiveEl = document.querySelector("#constat_five");
const searchEl = document.querySelector("#searchUser-bar");

const id_start = "constat";

let validated_once = [];

//REGEX/

const has_uppercase = /[A-Z]{1,}/;
const has_lowercase = /[a-z]{1,}/;
const has_number = /[0-9]{1,}/;
const has_special = /[$&+,:;=?@#|/\\'<>.^*()%!-]{1,}/;
const has_five = /[\s\S]{5,}/;

// VERIFICATIONS FUNCTIONS //

function is_valid(e) {
  const temp = document.querySelector("#" + id_start + e);
  const temp_status = document.querySelector("#" + id_start + e + "_status");

  if (!validated_once.includes(e)) {
    validated_once.push(e);
  }

  temp_status.style.transform = "rotate(360deg)";
  setTimeout(function () {
    temp.setAttribute("class", "is_valid");
    temp_status.setAttribute("class", "fa-solid fa-check");
  }, 200);
}

function is_not_valid(e) {
  const temp = document.querySelector("#" + id_start + e);
  const temp_status = document.querySelector("#" + id_start + e + "_status");

  if (validated_once.includes(e)) {
    temp_status.style.transform = "rotate(-360deg)";
  }

  setTimeout(function () {
    temp.setAttribute("class", "is_not_valid");
    temp_status.setAttribute("class", "fa-solid fa-xmark");
  }, 200);
}

function verifyPassword(e) {
  if (has_uppercase.test(e)) {
    is_valid("_upper");
  } else {
    is_not_valid("_upper");
  }
  if (has_lowercase.test(e)) {
    is_valid("_lower");
  } else {
    is_not_valid("_lower");
  }
  if (has_number.test(e)) {
    is_valid("_number");
  } else {
    is_not_valid("_number");
  }
  if (has_special.test(e)) {
    is_valid("_special");
  } else {
    is_not_valid("_special");
  }
  if (has_five.test(e)) {
    is_valid("_five");
  } else {
    is_not_valid("_five");
  }
  if (
    document.querySelector(".password-el-create").value ==
      document.querySelector(".rePassword-el-create").value &&
    document.querySelector(".password-el-create").value != ""
  ) {
    is_valid("_identical");
  } else {
    is_not_valid("_identical");
  }
}

function verifyRePassword() {
  if (
    document.querySelector(".password-el-create").value ==
      document.querySelector(".rePassword-el-create").value &&
    document.querySelector(".password-el-create").value != ""
  ) {
    is_valid("_identical");
  } else {
    is_not_valid("_identical");
  }
}

//-------------------------INDICATIONS PASSWORD-------------------------//

//----------------------CONTACT US----------------------//

if (document.querySelector("title").innerHTML == "Contact Us") {
  const contactForm = document.querySelector(".contact-us-form");
  const requestList = document.querySelector(".reqList-el");
  const regexText = /[a-zA-Z0-9]{50,300}/;

  let contactQuestionsCounter = 1;
  let textAreaHasPopped = false;
  let buttonHasPopped = false;

  if (document.querySelector("title").innerHTML == "Contact Us") {
    requestList.addEventListener("change", function () {
      if (document.getElementsByClassName("contact-userReport").length != 0) {
        document.querySelectorAll(".contact-userReport").forEach(function (e) {
          e.remove();
          contactQuestionsCounter--;
          textAreaHasPopped = false;
          if (document.querySelector(".contact-us-form button") != null) {
            document.querySelector(".contact-us-form button").remove();
            buttonHasPopped = false;
          }
        });
      }

      if (requestList.value == "1") {
        addElementToForm(
          "contactUs-label-username",
          "L'utilisateur mentionné",
          "userReport",
          "input",
          "text",
          "username",
          "contactUs-input-username",
          contactForm
        );

        document.getElementsByName("username").forEach(function (e) {
          e.addEventListener("keyup", function (e) {
            if (e.value != "" && !textAreaHasPopped) {
              textAreaToForm("Qu'a t-il fait ?", "Il m'a volé mon goûter.");
            }
          });
        });
      }
      if (requestList.value == "2") {
        addElementToForm(
          "contactUs-label-username",
          "Votre pseudo ou email",
          "userReport",
          "input",
          "text",
          "username",
          "contactUs-input-username",
          contactForm
        );
        document.getElementsByName("username").forEach(function (e) {
          e.addEventListener("keyup", function (e) {
            if (e.value != "" && !textAreaHasPopped) {
              textAreaToForm(
                "Expliquez-nous tout",
                "M Delon a piraté mon compte et m'a fait dire des choses bizarres."
              );
            }
          });
        });
      }
      if (requestList.value == "3") {
        textAreaToForm(
          "Décrivez-nous le problème",
          "Je n'ai plus le temps d'utiliser cet incroyable site depuis que je suis à l'ESGI, j'aimerais donc que vous me le supprimiez définitivement, si possible. Merci, vous êtes incroyables."
        );
      }
      if (requestList.value == "4") {
        textAreaToForm(
          "Décrivez votre problème",
          "Un erreur sur la page : easteregg.php est apparue soudainement."
        );
      }
      if (requestList.value == "5") {
        textAreaToForm(
          "Allez-y",
          "Et bien, je trouve Teddy vachement mignon.."
        );
      }
    });

    function textAreaToForm(label, placeholder) {
      addElementToForm(
        "contactUs-label-report",
        label,
        "userReport",
        "textarea",
        "text",
        "report",
        "contactUs-textarea-report",
        contactForm
      );
      document
        .querySelector("#contactUs-textarea-report")
        .setAttribute("minlength", "50");
      document
        .querySelector("#contactUs-textarea-report")
        .setAttribute("maxlength", "300");
      document
        .querySelector("#contactUs-textarea-report")
        .setAttribute(
          "placeholder",
          placeholder + " (Minimum 50 caractères, Maximum 300)"
        );

      textAreaHasPopped = true;

      document.getElementsByName("report").forEach(function (e) {
        e.addEventListener("change", function () {
          if (
            regexText.test(document.getElementsByName("report")[0].value) &&
            !buttonHasPopped
          ) {
            addButtonToForm("Envoyer ma demande", contactForm);
            buttonHasPopped = true;
          } else {
            if (document.querySelector(".contact-us-form button") != null) {
              document.querySelector(".contact-us-form button").remove();
              buttonHasPopped = false;
            }
          }
        });
      });
    }

    function addButtonToForm(content, insertedInto) {
      const buttonEl = document.createElement("button");
      buttonEl.setAttribute("type", "submit");
      buttonEl.innerHTML = content;
      insertedInto.appendChild(buttonEl);
    }

    function addElementToForm(
      labelId,
      labelContent,
      divClass,
      element,
      elementType,
      elementName,
      elementId,
      insertedInto
    ) {
      contactQuestionsCounter++;

      const div = document.createElement("div");
      div.setAttribute("class", "contact-us-form-div contact-" + divClass);
      const labelEl = document.createElement("label");
      labelEl.setAttribute("id", labelId);
      labelEl.innerHTML = contactQuestionsCounter + ". " + labelContent;
      div.appendChild(labelEl);

      const elementEl = document.createElement(element);
      elementEl.setAttribute("type", elementType);
      elementEl.setAttribute("name", elementName);
      elementEl.setAttribute("id", elementId);
      div.appendChild(elementEl);

      insertedInto.appendChild(div);
    }
  }
}

//POST WITH SORT AJAX FUNCTIONS AND LIKES/DISLIKES SYSTEM//

if (document.querySelector("title").innerHTML == "Lounge") {
  const searchPostEl = document.querySelector(".search-bar input");
  const categoryPostEl = document.getElementById("categories-select");
  const sortPostEl = document.getElementById("sort-select");

  postAjax(sortPost, 1);

  function postAjax(cFunction, page_number) {
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        cFunction(this);
      }
    };
    xhttp.open("POST", "includes/servers/sortPost.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
      "search=" +
        searchPostEl.value +
        "&category=" +
        categoryPostEl.value +
        "&sort=" +
        sortPostEl.value +
        "&page=" +
        page_number
    );
  }

  function sortPost(xhttp) {
    document.querySelector(".users-posts-main").innerHTML = xhttp.responseText;
  }

  function likePost(cFunction, option, id) {
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        cFunction(this, id);
      }
    };
    xhttp.open("POST", "includes/servers/likePost.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("q=" + option + "&id=" + id);
  }

  function likeCheck(xhttp, id) {
    document.querySelector("#like-dislike-post-" + id).innerHTML =
      xhttp.responseText;
  }
}
