const btnWeek = document.querySelectorAll(".btnWeek"),
    showday = document.getElementById("showday"),
    calendar = document.querySelector(".calendar");

btnWeek.forEach(button => {
    button.addEventListener("click", function(event){
        event.preventDefault();
        this.closest("form").submit();
        calendar.style.display = "block";
    });
});
