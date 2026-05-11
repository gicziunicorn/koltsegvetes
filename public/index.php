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
    <nav>
        <h1>Személyes Pénzügyi Tervező</h1>
        <?php if(isset($_SESSION['egyenleg'])): ?>
        <form action="../php/logout.php">
            <button id="logout">logout</button>
        </form>
        <?php endif; ?>
    </nav>
    <main>
        <?php if(!isset($_SESSION['egyenleg'])): ?>
        <p><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?> </p>
        <h2>Üdvözlünk<?php echo ($_SESSION['user_exists']) ? ", ".$_SESSION['nev'] : ""; ?>!</h2>
        <p><?php echo ($_SESSION['user_exists']) ? "Kérjük add meg a jelszavad:" : "Az adatbázis nem tartalmaz felhasználót. Kérjük hozz létre egyet!"; ?></p>
        <form action="../php/main.php" method="post">
            <?php if(!$_SESSION['user_exists']): ?>
                <label for="nev">Név: <input type="text" name="nev" id="nev" required></label>
            <?php endif; ?>
            <label for="pass">Jelszó: <input type="password" name="pass" id="pass" required></label>
            <button type="submit"><?php echo ($_SESSION['user_exists']) ? "Bejelentkezés" : "Létrehozás"; ?></button>
        </form>
        <?php endif; ?>

        <?php if(isset($_SESSION['egyenleg'])): ?>
            <h3>Az egyenleged: <?php echo($_SESSION['egyenleg']); ?>Ft</h3>
        <?php endif; ?>
    </main>
</body>
</html>