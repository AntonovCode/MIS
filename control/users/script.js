const createBtn = document.getElementById("createBtn");
const tbodyUserTable = document.querySelector(".user-table tbody");

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

tbodyUserTable.addEventListener('click', async function (event) {
    let element = event.target;
    
    if (element.tagName === 'BUTTON') {
        let userId = element.getAttribute('data-userid');
        let response = await fetch('/control/users/deleteUser.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'userId': userId
            })
        });
        
        if (response.ok) {
            let tr = element.parentElement.parentElement;
            tr.remove();
        }
    }
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
        
        fields.forEach(function (field) {
            let td = document.createElement("td");
            td.innerText = row[field];
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}