import { UserTableContextMenu } from "./UserTableContextMenu.js";

const createBtn = document.getElementById("createBtn");
let contextMenu = new UserTableContextMenu(".user-table", ".context-menu", getAllUsers);
let cancelChange = document.querySelector(".popup-fade button:nth-child(1)");
let changeBtn = document.querySelector(".popup-fade button:nth-child(2)");

createBtn.addEventListener("click", async function () {
    let fields = {};
    const fieldsNames = ["surname", "firstname", "lastname", "username", "password"];

    fieldsNames.forEach(function(name) {
        fields[name] = document.querySelector(`.new-user__fields input[name="${name}"]`).value;
    });

    const response = await fetch("/control/users/createUser.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(fields)
    });

    if (!response.ok) return;
    let data = await response.json();

    let statusElem = document.getElementById("status-message");

    if (data["error"] === "true") {
        statusElem.innerText = data["message"];
        statusElem.style.opacity = "1";
        setTimeout(clearStatusMessage, 2000);
        return;
    }
    
    statusElem.innerText = "Пользователь создан!";
    statusElem.style.opacity = "1";
    setTimeout(clearStatusMessage, 2000);

    fieldsNames.forEach(function (name) {
        document.querySelector(`.new-user__fields input[name="${name}"]`).value = "";
    });

    getAllUsers();
});

function clearStatusMessage() {
    let statusElem = document.getElementById("status-message");
    statusElem.innerText = "";
    statusElem.style.opacity = "0";
}

async function getAllUsers() {
    const response = await fetch("/control/users/getAllUsers.php");
    if (!response.ok) return;
    let data = await response.json();

    let tbody = document.querySelector(".user-table tbody");
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    data.forEach(function (row) {
        let tr = document.createElement("tr");
        const fields = ["rn", "surname", "firstname", "lastname", "username"];
        tr.setAttribute("data-userid", row["id"]);

        fields.forEach(function (field) {
            let td = document.createElement("td");
            td.innerText = row[field];
            
            if (field !== "rn") {
                td.setAttribute("data-field", field);
            }

            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}

function clearPopup () {
    let popupFade = document.querySelector(".popup-fade");
    let popup = popupFade.querySelector(".popup");

    popupFade.querySelector('input[name="surname"]').value = "";
    popupFade.querySelector('input[name="firstname"]').value = "";
    popupFade.querySelector('input[name="lastname"]').value = "";
    popupFade.querySelector('input[name="username"]').value = "";

    popup.removeAttribute("data-userid");
    popupFade.style.display = "none";
}

cancelChange.addEventListener("click", clearPopup);

changeBtn.addEventListener("click", async function () {
    let popupFade = document.querySelector(".popup-fade");
    let popup = popupFade.querySelector(".popup");
    let surnameInput   = popupFade.querySelector('input[name="surname"]');
    let firstnameInput = popupFade.querySelector('input[name="firstname"]');
    let lastnameInput  = popupFade.querySelector('input[name="lastname"]');
    let usernameInput  = popupFade.querySelector('input[name="username"]');

    let data = {
        "id": popup.getAttribute("data-userid"),
        "newSurname": surnameInput.value,
        "newFirstname": firstnameInput.value,
        "newLastname": lastnameInput.value,
        "newUsername": usernameInput.value
    };

    const response = await fetch("/control/users/updateUser.php", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    });

    if (!response.ok) return;
    let json = await response.json();
    clearPopup();
    getAllUsers();
});