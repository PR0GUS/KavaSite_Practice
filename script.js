var menuButton = document.getElementById("menuButton");
var navigation = document.getElementById("navigation");

menuButton.onclick = function() {
    if (navigation.style.display == "flex") {
        navigation.style.display = "none";
    } else {
        navigation.style.display = "flex";
    }
};

var infoButton = document.getElementById("infoButton");
var extraInfo = document.getElementById("extraInfo");

infoButton.onclick = function() {
    if (extraInfo.hidden == true) {
        extraInfo.hidden = false;
        infoButton.innerText = "Приховати";
    } else {
        extraInfo.hidden = true;
        infoButton.innerText = "Дізнатися більше";
    }
};

var themeButton = document.getElementById("themeButton");

if (localStorage.getItem("theme") == "dark") {
    document.body.classList.add("dark");
}

themeButton.onclick = function() {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
};

var drinks = [
    { name: "Капучино", price: "70 грн" },
    { name: "Лате", price: "80 грн" },
    { name: "Чай", price: "40 грн" }
];

var menuList = document.getElementById("menuList");
var addDrinkButton = document.getElementById("addDrinkButton");
var isAdmin = false;

if (addDrinkButton != null) {
    isAdmin = true;
}

function showDrinks() {

    menuList.innerHTML = "";
    for (var i = 0; i < drinks.length; i++) {

        var item = document.createElement("div");
        item.className = "menu-item";

        var title = document.createElement("h3");
        title.innerText = drinks[i].name;

        var price = document.createElement("p");
        price.innerText = drinks[i].price;

        item.appendChild(title);
        item.appendChild(price);

        if (isAdmin == true) {

            var deleteButton = document.createElement("button");
            deleteButton.innerText = "Видалити";

            deleteButton.onclick = function() {

                var itemToDelete = this.parentElement;
                var items = menuList.children;
                var number = 0;

                for (var j = 0; j < items.length; j++) {
                    if (items[j] == itemToDelete) {
                        number = j;
                    }
                }

                drinks.splice(number, 1);
                showDrinks();
            };

            item.appendChild(deleteButton);
        }

        menuList.appendChild(item);
    }
}

showDrinks();

if (addDrinkButton != null) {

    addDrinkButton.onclick = function() {

        var name = document.getElementById("drinkName").value.trim();
        var price = document.getElementById("drinkPrice").value.trim();

        if (name == "" || price == "") {

            alert("Введи назву і ціну напою!");

        } else if (name.length > 60 || !/^[0-9]+( грн)?$/.test(price)) {

            alert("Введи нормальну назву і ціну, наприклад 65 грн");

        } else {

            if (price.indexOf("грн") == -1) {
                price = price + " грн";
            }

            drinks.push({ name: name, price: price });

            showDrinks();

            document.getElementById("drinkName").value = "";
            document.getElementById("drinkPrice").value = "";
        }
    };
}

var contactForm = document.getElementById("contactForm");
contactForm.onsubmit = async function(event) {

    event.preventDefault();

    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();
    var message = document.getElementById("message").value.trim();

    var formError = document.getElementById("formError");
    var formSuccess = document.getElementById("formSuccess");

    formError.innerText = "";
    formSuccess.innerText = "";

    if (name == "" || email == "" || message == "") {
        formError.innerText = "Заповни всі поля!";
        return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        formError.innerText = "Неправильний email";
        return;
    }

    try {

        var response = await fetch("save_message.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                name: name,
                email: email,
                message: message
            })
        });

        var result = await response.json();

        if (response.ok && result.success) {
            formSuccess.innerText = result.message;
            contactForm.reset();
        } else {
            formError.innerText = result.error || "Сталася помилка!";
        }

    } catch (error) {
        formError.innerText = "Не вдалося підключитися до сервера!";
    }
};