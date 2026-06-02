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
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.2/jquery-ui.js"></script>
    <?php endif; ?>
</head>

<body>
    <div id="overlay" style="display:none;background-color:#00000044;position:fixed;top:0;left:0;width:100vw;height:100vh;pointer-events:none;z-index:10;"></div>
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
            <p> <?php if( isset($_SESSION['msg']) ) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }?> </p>
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
    <div id="editor-cont" style="display: none;">
        <div id="editor">
            <button id="close-editor">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
            <h3></h3>
            <div>
                <label for="osszeg">Összeg (huf):</label>
                <input name="editor" id="osszeg" type="text" required inputmode="numeric">
            </div>
            <div>
                <label for="idopont">Időpont:</label>
                <input type="text" name="editor" id="idopont" readonly>
            </div>
            <div id="categories">
            </div>
            <div id="note-cont">
                <p>Jegyzet</p>
                <span>0 / 100 karakter</span>
                <textarea name="editor" id="note"></textarea>
            </div>
            <button id="submit"></button>
        </div>
    </div>

    <main id="data-main">
        <div id="egyenleg" class="container">
            <h3>Az egyenleged</h3>
            <p id="egyenleg-p">Ft</p>
            <hr>
        </div>
        <div id="bevetelek" class="long container">
            <h3>Bevételeid</h3>
            <button class="add" id="bev-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
        </div>
        <div id="kiadasok" class="long container">
            <h3>Kiadásaid</h3>
            <button class="add" id="kiad-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
        </div>
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