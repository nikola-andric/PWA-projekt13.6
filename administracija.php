<?php

    include 'connect.php';
    session_start();
    
    // UPIT NA BAZU //

    $query = "SELECT * FROM `vijesti`";
    $result = mysqli_query ($veza,$query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>PWA</title>
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
            <?php
                while ($red = mysqli_fetch_array($result))
                {
                    echo '
                        <form enctype="multipart/form-data" method="POST" action="">
                            <label for="naslov">Naslov vijesti</label><br>
                            <input type="text" name="naslov_vijesti" value="' .$red['naslov']. '"><br><br>
                            <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 190 znakova)</label><br>
                            <textarea cols="50" rows="12" name="kratki_sadrzaj" maxlength="190">' .$red['kratki_sadrzaj']. '</textarea><br><br>
                            <label for="sadrzaj_vijesti">Sadržaj vijesti</label><br>
                            <textarea cols="50" rows="12" name="sadrzaj_vijesti">' .$red['sadrzaj']. '</textarea><br><br>
                            <label for="slika" class="slika">Slika:</label><br>
                            <input type="file" accept="image/*" name="slika" value="' .$red['slika']. '"><br>
                            <img src="img/' .$red['slika']. '" width=100px><br><br>
                            <label for="kategorija">Kategorija vijesti:</label><br>
                            <select name="kategorija" class="kategorija" value="' .$red['kategorija']. '">
                                <option value="Politika">Politika</option>
                                <option value="GAMING">Gaming</option>
                                <option value="TEHNOLOGIJA">Sport</option>
                                <option value="YOUTUBE">YouTube</option>
                            </select><br><br>
                            <label for="spremiti">Spremiti u arhivu:</label><br>';
                            if ($red['arhiva'] == 0)
                            {
                                echo '<input type="checkbox" name="arhiva" id="arhiva"><br><br>';
                            }
                            else 
                            {
                                echo '<input type="checkbox" name="arhiva" id="arhiva" checked><br><br>';
                            }
                    echo '
                            <input type="hidden" name="id" value="' .$red['id']. '">
                            <input type="submit" value="Pošalji" name="reset" id="reset_submit">
                            <input type="reset" value="Poništi" name="submit" id="reset_submit"><br>
                            <input type="submit" value="Izbriši" name="delete" id="reset_submit">
                            <input type="submit" value="Izmjeni" name="update" id="reset_submit">
                        </form>';
                }
            ?>
        </div>
    </main>
    <footer>
        <div id="center">
            <p>Stranicu napravio:Nikola Andric</p>
            <b><p>Copyright © 2021 BMK.</p></b>
        </div>
    </footer>
</body>
</html>

<?php

  // UPIT NA BAZU //

  $query = "SELECT * FROM `vijesti`";
  $result = mysqli_query ($veza,$query);

  if (isset($_POST['delete']))
  {
      $id = $_POST['id'];

      // UPIT NA BAZU //

      $query = "DELETE FROM `vijesti` WHERE id=?";
      $stmt = mysqli_stmt_init($veza);
      if (mysqli_stmt_prepare($stmt,$query))
      {
          mysqli_stmt_bind_param($stmt,'s',$id);
          mysqli_stmt_execute($stmt);
      }
  }
  if (isset($_POST['update']))
  {
      $id = $_POST['id'];
      $kategorija = $_POST['kategorija'];
      $naslov = $_POST['naslov_vijesti'];
      $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
      $sadrzaj = $_POST['sadrzaj_vijesti'];
      $slika = $_FILES['slika']['name'];
      
      if (isset($_POST['arhiva']))
      {
          $arhiva = 'Y';
      }
      else 
      {
          $arhiva = 'N';
      }

      $target = 'img/' .$slika;
      move_uploaded_file($_FILES['slika']['tmp_name'],'$target');

    // UPIT NA BAZU //

            $query = "UPDATE `vijesti` SET `kategorija`=?,`naslov`=?,`kratki_sadrzaj`=?,`sadrzaj`=?,`slika`=?,`arhiva`=? WHERE id=?";
            $stmt = mysqli_stmt_init($veza);
            if (mysqli_stmt_prepare($stmt,$query))
            {
                mysqli_stmt_bind_param($stmt,'sssssss',$kategorija,$naslov,$kratki_sadrzaj,$sadrzaj,$slika,$arhiva,$id);
                mysqli_stmt_execute($stmt);
            }
        }

        if (isset($_POST['update']) || isset($_POST['delete']))
        {
            // ODSPAJANJE SA BAZOM //

    mysqli_close ($veza);
    header("Location:administracija.php");
}


    // ODSPAJANJE SA BAZOM //

    mysqli_close ($veza);

?>