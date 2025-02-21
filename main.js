document.addEventListener("DOMContentLoaded", function() {
  document.querySelector(".icons .fa-bell").addEventListener("click", handleNotification);
  document.querySelector(".icons .fa-circle-user").addEventListener("click", handleSettings);
});

function handleNotification() { 
  alert('Notification button clicked!'); 
}

function handleSettings() { 
  alert('Settings button clicked!'); 
}
document.addEventListener("DOMContentLoaded", function() {
  const form = document.querySelector("form");

  form.addEventListener("submit", function(event) {
    event.preventDefault(); // منع إعادة تحميل الصفحة

    const fullName = document.getElementById("fullName").value;
    const nickname = document.getElementById("nickname").value;
    const email = document.getElementById("email").value;
    const country = document.getElementById("country").value;

    if (fullName && nickname && email && country) {
      alert("تم التسجيل بنجاح!");
    } else {
      alert("يرجى ملء جميع الحقول!");
    }
  });
});