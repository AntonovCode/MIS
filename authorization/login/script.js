let authBtn = document.querySelector(".authorization-btn");

authBtn.addEventListener("click", async () => {
    const data = {
        "login": document.getElementById("login-input").value,
        "password": document.getElementById("password-input").value
    };

    let response = await fetch("/authorization/login/authorization.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        redirect: "follow",
        body: JSON.stringify(data)
    });

    window.location = response.url;
});