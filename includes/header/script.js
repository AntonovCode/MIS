const exitBtn = document.querySelector(".exit");

exitBtn.addEventListener("click", async () => {
    let response = await fetch("/authorization/logout.php");
    window.location = response.url;
});