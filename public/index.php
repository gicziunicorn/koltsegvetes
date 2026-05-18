<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Személyes Pénzügyi Tervező</title>
    <link rel="stylesheet" href="./style.css">
    <?php if (isset($_SESSION['egyenleg'])): ?>
        <script src="./main.js" defer></script>
    <?php endif; ?>
</head>

<body>
    <div id="overlay" style="background-color:#00000044;position:fixed;top:0;left:0;width:100vw;height:100vh;pointer-events:none"></div>
    <nav>
        <h1>Személyes Pénzügyi Tervező</h1>
        <?php if(isset($_SESSION['egyenleg'])): ?>
        <form action="../php/logout.php">
            <button id="logout-button">logout</button>
        </form>
        <?php endif; ?>
    </nav>

    <?php if(!isset($_SESSION['egyenleg'])): ?>
    <main id="form-main">
        <div id="form">
            <p> <?php echo $_SESSION['msg']; unset($_SESSION['msg']);?> </p>
            <h2>Üdvözlünk<?php echo ($_SESSION['user_exists']) ? ", ".$_SESSION['nev'] : ""; ?>!</h2>
            <p><?php echo ($_SESSION['user_exists']) ? "Kérjük add meg a jelszavad:" : "Az adatbázis nem tartalmaz felhasználót. Kérjük hozz létre egyet!"; ?></p>
            <form action="../php/main.php" method="post">
                <?php if(!$_SESSION['user_exists']): ?>
                <div>
                    <input name="nev" id="nev" type="text" required>
                    <label for="nev">Név</label>
                </div>
                <?php endif; ?>
                <div>
                    <input name="pass" id="pass" type="password" required autocomplete="off">
                    <label for="pass" >Jelszó</label>
                    <button type="button" id="show-pw">
                        <img src="./pics/eye-closed.svg" alt="show">
                    </button>
                </div>
                <button type="submit"><?php echo ($_SESSION['user_exists']) ? "Bejelentkezés" : "Létrehozás"; ?></button>
            </form>
        </div>
    </main>
    <?php endif; ?>

    <?php if(isset($_SESSION['egyenleg'])): ?>
    <main id="data-main">
        <div id="egyenleg">
            <h3>Az egyenleged: <?php echo($_SESSION['egyenleg']); ?> Ft</h3>
        </div>
        <div id="bevetelek"></div>
        <div id="kiadasok"></div>
    </main>
    <?php endif; ?>


<?php if(!isset($_SESSION['egyenleg'])): ?>
    <script>  // show password button
        const button = document.getElementById('show-pw');
        button.addEventListener("click", () => {
            const pass = document.getElementById("pass");
            pass.type = pass.type === "password" ? "text" : "password";
            button.querySelector("img").src = `./pics/eye-${pass.type==="password"? "closed":"open"}.svg`;
        })
    </script>
<?php endif; ?>
</body>
</html>