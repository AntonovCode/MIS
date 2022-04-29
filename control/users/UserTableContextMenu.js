export class UserTableContextMenu {
    constructor(tableSelector, menuSelector, onRefreshCallback) {
        this.selectedUser = null;
        this.contextMenu = document.querySelector(menuSelector);
        this.onRefreshCallback = onRefreshCallback;

        let tbody = document.querySelector(tableSelector + " tbody");
        let refreshBtn = this.contextMenu.querySelector('div[data-table-popup-btn="refresh"]');
        let updateBtn  = this.contextMenu.querySelector('div[data-table-popup-btn="update"]');
        let deleteBtn  = this.contextMenu.querySelector('div[data-table-popup-btn="delete"]');

        tbody.addEventListener("contextmenu", this);
        document.addEventListener("click",    this);
        refreshBtn.addEventListener("click",  this);
        updateBtn.addEventListener("click",   this);
        deleteBtn.addEventListener("click",   this);
    }

    handleEvent(event) {
        switch(event.type) {
            case "contextmenu":
                this.onContextMenu(event);    
                break;
            case "click":
                if (event.currentTarget === document) {
                    this.onClickDocument(event);
                    break;
                };
                let action = event.currentTarget.getAttribute("data-table-popup-btn");
                action = action.charAt(0).toUpperCase() + action.slice(1);
                this[`onClick${action}`](event);
        }
    }

    onContextMenu(event) {
        this.contextMenu.style.display = "block";
        this.contextMenu.style.top  = event.clientY + "px";
        this.contextMenu.style.left = event.clientX + "px";
        
        if (this.selectedUser !== null) {
            this.selectedUser.style.backgroundColor = "";
            this.selectedUser = null;
        }
        this.selectedUser = event.target.closest("tr");
        this.selectedUser.style.backgroundColor = "pink";
        event.preventDefault();
    }

    onClickDocument(event) {
        this.contextMenu.style.display = "none";
        if (this.selectedUser !== null) {
            this.selectedUser.style.backgroundColor = "";
            this.selectedUser = null;
        }
    }

    onClickRefresh(event) {
        this.onRefreshCallback();
    }

    onClickUpdate(event) {
        let popupFade = document.querySelector(".popup-fade");
        let surnameInput   = popupFade.querySelector('input[name="surname"]');
        let firstnameInput = popupFade.querySelector('input[name="firstname"]');
        let lastnameInput  = popupFade.querySelector('input[name="lastname"]');
        let usernameInput  = popupFade.querySelector('input[name="username"]');
        let popup = popupFade.querySelector(".popup");
        popup.setAttribute("data-userid", this.selectedUser.getAttribute("data-userid"));

        let surnameTd = this.selectedUser.querySelector('td[data-field="surname"]');
        let firstnameTd = this.selectedUser.querySelector('td[data-field="firstname"]');
        let lastnameTd = this.selectedUser.querySelector('td[data-field="lastname"]');
        let usernameTd = this.selectedUser.querySelector('td[data-field="username"]');

        surnameInput.value = surnameTd.innerText;
        firstnameInput.value = firstnameTd.innerText;
        lastnameInput.value = lastnameTd.innerText;
        usernameInput.value = usernameTd.innerText;
        popupFade.style.display = "flex";
    }

    async onClickDelete(event) {
        event.stopPropagation();

        let userId = this.selectedUser.getAttribute('data-userid');
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
            this.selectedUser.remove();
            this.selectedUser = null;
        }
        document.querySelector("body").click();
    }
}