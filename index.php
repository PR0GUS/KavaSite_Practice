<?php
session_start();

$isAdmin = isset($_SESSION["admin"]);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сімейна кав'ярня</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Сімейна кав'ярня</h1>
       
        <button id="menuButton" type="button">Меню ☰</button>

 <nav id="navigation">
    <a href="#about">Про нас</a>
    <a href="#menu">Меню</a>
    <a href="#cafe">Наше кафе</a>
    <a href="#contact">Контакти</a>

    <?php if ($isAdmin) { ?>
        <a href="messages.php">Адмінпанель</a>
        <a href="logout.php">Вийти</a>
    <?php } else { ?>
        <a href="login.php">Вхід адміністратора</a>
    <?php } ?>
</nav>

        <button id="themeButton" type="button">Змінити тему</button>
    </header>

    <main>
        <section id="about">
            <h2>Про нас</h2>
            <p>Наша сімейна кав'ярня - це місце, де можна випити смачної кави
            та відпочити з друзями.</p>

            <button id="infoButton" type="button">Дізнатися більше</button>
            <p id="extraInfo" hidden>У нас затишна атмосфера, свіжа кава та смачні напої для кожного гостя.</p>

            <img src="images/coffee.jpg" alt="Чашка кави" width="400" height="400">
        </section>

    <section id="menu">
       <h2>Наше меню</h2>

       <div class="menu" id="menuList"></div>

       <?php if ($isAdmin) { ?>

        <h3>Додати напій</h3>

        <input type="text" id="drinkName" placeholder="Назва напою">

        <input type="text" id="drinkPrice" placeholder="Ціна, наприклад 65 грн">

        <button id="addDrinkButton" type="button">Додати напій</button>

    <?php } ?>

</section>

        <section id="cafe">
            <h2>Інтер'єр нашого сімейного кафе</h2>
            <img src="images/cafe.jpg" alt="Інтер'єр кав'ярні" width="400" height="400">
        </section>

        <section id="contact">
            <h2>Контакти</h2>
            <p>Адреса: Київ, вул. Центральна, 10</p>
            <p>Email: familycoffee@ukr.net</p>

            <h3>Напишіть нам</h3>

            <form id="contactForm" novalidate>
                <label for="name">Ім'я:</label>
                <input type="text" id="name" name="name" autocomplete="name">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" autocomplete="email">

                <label for="message">Повідомлення:</label>
                <textarea id="message" name="message"></textarea>

                <button type="submit">Надіслати</button>
            </form>
            <p id="formError" role="alert"></p>
            <p id="formSuccess" role="status"></p>
        </section>
    </main>

    <footer>
        <p>Сімейна кав'ярня, 2026</p>
        <p>Телефон: +380 63 777 88 99</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
