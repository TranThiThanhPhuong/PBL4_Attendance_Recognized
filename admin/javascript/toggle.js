const body = document.querySelector("body");
const sidebar = document.querySelector(".sidebar");
const toggle = document.querySelector(".toggle");
const modeswitch = document.querySelector(".toggle-switch");
const modetext = document.querySelector(".mode-text");
const logoImg = document.getElementById("logo-img");
const home = document.querySelector(".home")

toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});
 
modeswitch.addEventListener("click", () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")){
        modetext.innerText = "Light";
        logoImg.src = "../image/Nihongo.png"; 
    }
    else {
        modetext.innerText = "Dark";
        logoImg.src = "../image/Nihongo2.png"; 
    }

});

document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.pathname;
    const links = document.querySelectorAll('.sidebar a');

    // Đặt trạng thái `active-link` dựa vào đường dẫn được lưu trong localStorage
    const activeLink = localStorage.getItem('activeLink');
    links.forEach(function(link) {
        if (link.getAttribute('href') === activeLink) {
            link.classList.add('active-link');
        } else {
            link.classList.remove('active-link'); 
        }
    });

    // Lưu đường dẫn của thẻ `<a>` khi nhấn vào
    links.forEach(function(link) {
        link.addEventListener('click', function() {
            localStorage.setItem('activeLink', link.getAttribute('href'));
        });
    });
});


