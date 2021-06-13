<?php

    session_start();
    include 'connect.php';
    setlocale(LC_ALL,'croatian'); 
    $datum = ucwords (iconv('ISO-8859-2', 'UTF-8',strftime('%A, %d %B')));
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>stern</title>
    <meta charset="UTF-8"/>
    <meta name="author" content="Nikola Andric"/>
    <meta http-equiv="content-language" content="hr"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="icon" href="img/stern-logo-fav.png" type="image/x-icon">
</head>
<body>
    <header>
        <div id="center">
            <nav>
                <ul>
                    <li><a href="index.php"><img src="img/stern-logo.png"></a></li>
                    <li class="lista_polozaj"><a href="index.php">Početna</a></li>
                    <li class="lista_polozaj"><a href="vijesti.php">Vijesti</a></li>
                    <li class="lista_polozaj"><a href="unos.php">Unos</a></li>
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
    <main>
        <div id="center">
            <h2 id="welcome">Dobrodošli!</h2>
            <h2 id="datum">
                <?php
                    echo $datum;
                ?>
            </h2>
            <section class="section_index">
                <h2>Igre</h2>
                <?php

                    // UPIT ZA BAZU //

                    $query = "SELECT * FROM `vijesti` WHERE arhiva=? AND kategorija=? ORDER BY `vijesti`.`vrijeme` DESC LIMIT 3";
                    $arhiva_baza = 'N';
                    $kategorija_baza = 'gaming';
                    $stmt = mysqli_stmt_init($veza);
                    if (mysqli_stmt_prepare($stmt,$query))
                    {
                        mysqli_stmt_bind_param($stmt,'ss',$arhiva_baza,$kategorija_baza);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }
                    mysqli_stmt_bind_result($stmt,$autor_id,$autor_username,$autor_kategorija,$autor_naslov,$autor_kratkisad,$autor_sadrzaj,$autor_slika,$autor_arhiva,$autor_vrijeme);
                    while (mysqli_stmt_fetch($stmt))
                    {
                        echo '<article>';
                        echo '<a href="clanak.php?id=' .$autor_id. '">';
                        echo '<img src="img/' .$autor_slika.   '">';
                        echo '<h3>' .$autor_naslov. '</h3></a>';
                        echo '<p>' .$autor_kratkisad. '</p>';
                        echo '</article>';
                    }
                    ?>
            </section>
            <section class="section_index">
                <h2>Politika</h2>
                <?php

                        // UPIT ZA BAZU //

                        $query = "SELECT * FROM `vijesti` WHERE arhiva=? AND kategorija=? ORDER BY `vijesti`.`vrijeme` DESC LIMIT 3";
                        $arhiva_baza = 'N';
                        $kategorija_baza = 'politika';
                        $stmt = mysqli_stmt_init($veza);
                        if (mysqli_stmt_prepare($stmt,$query))
                        {
                            mysqli_stmt_bind_param($stmt,'ss',$arhiva_baza,$kategorija_baza);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                        }
                        mysqli_stmt_bind_result($stmt,$autor_id,$autor_username,$autor_kategorija,$autor_naslov,$autor_kratkisad,$autor_sadrzaj,$autor_slika,$autor_arhiva,$autor_vrijeme);
                        while (mysqli_stmt_fetch($stmt))
                        {
                            echo '<article>';
                            echo '<a href="clanak.php?id=' .$autor_id. '">';
                            echo '<img src="img/' .$autor_slika.   '">';
                            echo '<h3>' .$autor_naslov. '</h3></a>';
                            echo '<p>' .$autor_kratkisad. '</p>';
                            echo '</article>';
                        }
                        ?>
            </section>
            <section class="section_index">
                <h2>Sport</h2>
                <?php

                        // UPIT ZA BAZU //

                        $query = "SELECT * FROM `vijesti` WHERE arhiva=? AND kategorija=? ORDER BY `vijesti`.`vrijeme` DESC LIMIT 3";
                        $arhiva_baza = 'N';
                        $kategorija_baza = 'sport';
                        $stmt = mysqli_stmt_init($veza);
                        if (mysqli_stmt_prepare($stmt,$query))
                        {
                            mysqli_stmt_bind_param($stmt,'ss',$arhiva_baza,$kategorija_baza);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                        }
                        mysqli_stmt_bind_result($stmt,$autor_id,$autor_username,$autor_kategorija,$autor_naslov,$autor_kratkisad,$autor_sadrzaj,$autor_slika,$autor_arhiva,$autor_vrijeme);
                        while (mysqli_stmt_fetch($stmt))
                        {
                            echo '<article>';
                            echo '<a href="clanak.php?id=' .$autor_id. '">';
                            echo '<img src="img/' .$autor_slika.   '">';
                            echo '<h3>' .$autor_naslov. '</h3></a>';
                            echo '<p>' .$autor_kratkisad. '</p>';
                            echo '</article>';
                        }
                        ?>
        </div>
    </main>
    <footer>
            <p>Stranicu napravio:Nikola Andric</p>
            <b><p>Copyright © 2021.</p></b>

    </footer>
</body>
</html>

<?php

    // ODSPAJANJE SA BAZOM //

    mysqli_close ($veza);

?>