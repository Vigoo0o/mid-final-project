function openPopup(type) {
  let companyLink = document.getElementById("companyLink");
  let userLink = document.getElementById("userLink");

  if (type === "register") {
    companyLink.href = "./companySignUp.php";
    userLink.href = "./userSignUp.php";
  }
}
