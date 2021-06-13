<?php

    session_start();
    include 'connect.php';
    setlocale(LC_ALL,'croatian'); 
    $datum = ucwords (iconv('ISO-8859-2', 'UTF-8',strftime('%A, %d %B')));
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>PWA</title>
    <meta charset="UTF-8"/>
    <meta name="author" content="Nikola Andrić"/>
    <meta http-equiv="content-language" content="hr"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="icon" href="img/stern-logo-fav.png" type="image/x-icon">
</head>
<body>
    <header>
        <div id="center">
            <nav>
                <ul>
                    <li><a href="index.php"><img src="img/bmk-logo.png"></a></li>
                    <li class="lista_polozaj"><a href="index.php">Početna</a></li>
                    <li class="lista_polozaj"><a href="vijesti.php">Vijesti</a></li>
                    <li class="lista_polozaj"><a href="unos.php">Unos vijesti</a></li>
                    <li class="lista_polozaj"><a href="administracija.php">Administracija</a></li>
                </ul>
                <ul id="prijava_registracija">
                    <?php
                        if (isset($_SESSION['username']))
                        {
                            echo '
                                <li><a href="">' .$_SESSION['username']. '</a></li>
                                <li><a href="logout.php">Odjava</a></li>
                            ';
                        }
                        else
                        {
                            echo '
                                <li><a href="login.php">Prijava</a></li>
                                <li><a href="register.php">Registracija</a></li>
                            ';
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main id="register">
        <div id="center">
            <?php
                if (isset($_SESSION['isti_email']))
                {
                    echo '<p class="registracija_error">';
                    echo '<b>Uneseni e-mail se već koristi !</b>';
                    echo '<br><br></p>';
                    unset($_SESSION['isti_email']);
                }
                if (isset($_SESSION['isti_user']))
                {
                    echo '<p class="registracija_user_error">';
                    echo '<b>Uneseno korisničko ime se već koristi !</b>';
                    echo '<br><br></p>';
                    unset($_SESSION['isti_user']);
                }
                if (isset($_SESSION['registracija']))
                {
                    echo '<p class="registracija_tekst">';
                    echo "Uspješna registracija !";
                    echo "<br>Dobro došli <b>" .$_SESSION['ime']. "</b> !</p>";
                    unset($_SESSION['registracija']);
                    unset($_SESSION['ime']);
                }
                else
                {
                    echo '
                        <form method="POST">
                            <label for="ime">Ime</label><br>
                            <input type="text" name="ime" id="ime" autofocus>
                            <span id="porukaIme" class="error"></span><br><br>
                            <label for="prezime">Prezime</label><br>
                            <input type="text" name="prezime" id="prezime">
                            <span id="porukaPrezime" class="error"></span><br><br>
                            <label for="username">Username</label><br>
                            <input type="text" name="username" id="username">
                            <span id="porukaUsername" class="error"></span><br><br>
                            <label for="e-mail">E-mail</label><br>
                            <input type="email" name="e-mail" id="email">
                            <span id="porukaEmail" class="error"></span><br><br>
                            <label for="sifra">Lozinka</label><br>
                            <input type="password" name="sifra" id="lozinka">
                            <span id="porukaLozinka" class="error"></span><br><br>
                            <input type="submit" value="Registracija" class="reset_submit" id="reg">
                            <input type="reset" value="Poništi" class="reset_submit">
                        </form>
                    ';
                }
                
                if (isset($_POST['ime']))
                {
                    $ime = $_POST['ime'];
                    $prezime = $_POST['prezime'];
                    $username = $_POST['username'];
                    $e_mail = $_POST['e-mail'];
                    $sifra = password_hash($_POST['sifra'],CRYPT_BLOWFISH);

                    // PROVJERA DA LI POSTOJI ISTI E-MAIL ILI USERNAME U BAZI //

                    $query = "SELECT * FROM `korisnici`";
                    $result = mysqli_query ($veza,$query);
                    
                    while ($red = mysqli_fetch_array ($result))
                    {
                        if ($red['email_korisnika'] == $e_mail)
                        {
                            $_SESSION['isti_email'] = 1;
                            header("Location:register.php");
                        }
                        if ($red['username_korisnika'] == $username)
                        {
                            $_SESSION['isti_user'] = 1;
                            header("Location:register.php");
                        }
                    }

                    if (!isset($_SESSION['isti_email']) && !isset($_SESSION['isti_user']))
                    {
                
                        // UPIT ZA BAZU //
                
                        $query = "INSERT INTO `korisnici`(`ime_korisnika`, `prezime_korisnika`, `email_korisnika`, `username_korisnika`, `sifra_korisnika`) VALUES (?,?,?,?,?)";
                        $stmt = mysqli_stmt_init($veza);
                
                        if (mysqli_stmt_prepare($stmt,$query))
                        {
                            mysqli_stmt_bind_param($stmt,'sssss',$ime,$prezime,$e_mail,$username,$sifra);
                            if (mysqli_stmt_execute($stmt))
                            {
                                $_SESSION['registracija'] = 1;
                                $_SESSION['ime'] = $ime;
                                header("Location:register.php");
                            }
                        
                        }
                    }
                }
            ?>
            <script type="text/javascript">
                document.getElementById("reg").onclick = function (event)
                {
                    var forma = true

                    // IME //

                    var poljeIme = document.getElementById("ime")
                    var ime = document.getElementById("ime").value

                    if (ime.length < 1)
                    {
                        var forma = false
                        poljeIme.style.border = "1px dashed red"
                        document.getElementById("porukaIme").innerHTML = "<br>Polje Ime je obavezno !"
                    }

                    // PREZIME //
                    
                    var poljePrezime = document.getElementById("prezime")
                    var prezime = document.getElementById("prezime").value

                    if (prezime.length < 1)
                    {
                        var forma = false
                        poljePrezime.style.border = "1px dashed red"
                        document.getElementById("porukaPrezime").innerHTML = "<br>Polje Prezime je obavezno !"
                    }

                    // E-MAIL //

                    var poljeEmail = document.getElementById("email")
                    var email = document.getElementById("email").value

                    if (email.length < 1)
                    {
                        var forma = false
                        poljeEmail.style.border = "1px dashed red"
                        document.getElementById("porukaEmail").innerHTML = "<br>Polje E-mail je obavezno !"
                    }

                    // USERNAME //

                    var poljeUsername = document.getElementById("username")
                    var username = document.getElementById("username").value

                    if (username.length < 1)
                    {
                        var forma = false
                        poljeUsername.style.border = "1px dashed red"
                        document.getElementById("porukaUsername").innerHTML = "<br>Polje Username je obavezno !"
                    }

                    // LOZINKA //

                    var poljeLozinka = document.getElementById("lozinka")
                    var lozinka = document.getElementById("lozinka").value

                    
                    if (lozinka.length < 1)
                    {
                        var forma = false
                        poljeLozinka.style.border = "1px dashed red"
                        document.getElementById("porukaLozinka").innerHTML = "<br>Polje Lozinka je obavezno !"
                    }
                    else if (lozinka.length < 6)
                    {
                        var forma = false
                        poljeLozinka.style.border = "1px dashed red"
                        document.getElementById("porukaLozinka").innerHTML = "<br>Lozinka mora biti duža od 5 znakova !"
                    }

                    if (forma != true)
                    {
                        event.preventDefault()
                    }
                }
            </script>
        </div>
    </main>
    <footer>
        <div id="center">
            <p>nandric@tvz.hr</p>
            <b><p>Copyright © 2021 BMK.</p></b>
        </div>
    </footer>
</body>
</html>

<?php
 
    // ODSPAJANJE SA BAZOM //

    mysqli_close ($veza);

?>