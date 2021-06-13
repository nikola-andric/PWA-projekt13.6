<?php

    session_start();

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
            <form enctype="multipart/form-data" method="POST" action="skripta.php">
                    
            
                <span id="porukaTitle" class="bojaPoruke"></span>
                <label for="naslov">Naslov vijesti</label><br>
                <input type="text" name="naslov_vijesti" id="naslov" autofocus ><br><br>
                
                <span id="porukaAbout" class="bojaPoruke"></span>
                <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 190 znakova)</label><br>
                <textarea cols="50" rows="12" name="kratki_sadrzaj" maxlength="190" id="kratki_sadrzaj"></textarea><br><br>
                
                <span id="porukaContent" class="bojaPoruke"></span>
                <label for="sadrzaj_vijesti">Sadržaj vijesti</label><br>
                <textarea cols="50" rows="12" name="sadrzaj_vijesti" id="sadrzaj_vijesti"></textarea><br><br>
                
                <span id="porukaSlika" class="bojaPoruke"></span>
                <label for="slika" class="slika">Slika:</label><br>
                <input type="file" accept="image/*" name="slika" id="slika"><br><br>
                
                
                <span id="porukaKategorija" class="bojaPoruke"></span>
                <label for="kategorija">Kategorija vijesti:</label><br>
                <select name="kategorija" class="kategorija" id="kategorija">
                    <option value="Politika">Politika</option>
                    <option value="GAMING">Igre</option>
                    <option value="Sport">Sport</option>
                    <option value="YOUTUBE">YouTube</option>
                
                </select><br><br>
                <label for="spremiti">Spremiti u arhivu:</label><br>
                <input type="checkbox" name="arhiva" id="arhiva"><br><br>
                
                <button type="reset" value="Poništi">Poništi </button>
                
                <button type="submit" value="Prihvati" id="slanje">Prihvati </button>
            </form>
        </div>
    </main>
    <footer>
        <div id="center">
            <p>Stranicu napravio:Nikola Andrić</p>
            <b><p>Copyright © 2021</p></b>
        </div>
    </footer>


    <script type="text/javascript">
 // Provjera forme prije slanja
 document.getElementById("slanje").onclick = function(event) {

 var slanjeForme = true;

 // Naslov vjesti (5-30 znakova)
 var poljeTitle = document.getElementById("naslov");
 var title = document.getElementById("naslov").value;
 if (title.length < 5 || title.length > 30) {
 slanjeForme = false;
 poljeTitle.style.border="1px dashed red";
 document.getElementById("porukaTitle").innerHTML="Naslov vijesti mora imati između 5 i 30 znakova!</br>";
 } else {
 poljeTitle.style.border="1px solid green";
 document.getElementById("porukaTitle").innerHTML="";
 }

 // Kratki sadržaj (10-100 znakova)
 var poljeAbout = document.getElementById("kratki_sadrzaj");
 var about = document.getElementById("kratki_sadrzaj").value;
 if (about.length < 10 || about.length > 100) {
 slanjeForme = false;
 poljeAbout.style.border="1px dashed red";
 document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
 } else {
 poljeAbout.style.border="1px solid green";
 document.getElementById("porukaAbout").innerHTML="";
 }
 // Sadržaj mora biti unesen
 var poljeContent = document.getElementById("sadrzaj_vijesti");
 var content = document.getElementById("sadrzaj_vijesti").value;
 if (content.length == 0) {
 slanjeForme = false;
 poljeContent.style.border="1px dashed red";
 document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
 } else {
 poljeContent.style.border="1px solid green";
10
 document.getElementById("porukaContent").innerHTML="";
 }





 // Slika mora biti unesena
 var poljeSlika = document.getElementById("slika");
 var pphoto = document.getElementById("slika").value;
 if (pphoto.length == 0) {
 slanjeForme = false;
 poljeSlika.style.border="1px dashed red";
 document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
 } else {
 poljeSlika.style.border="1px solid green";
 document.getElementById("porukaSlika").innerHTML="";
 }



 // Kategorija mora biti odabrana
 var poljeCategory = document.getElementById("kategorija");
 if(document.getElementById("kategorija").selectedIndex == 0) {
 slanjeForme = false;
 poljeCategory.style.border="1px dashed red";

document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
 } else {
 poljeCategory.style.border="1px solid green";
 document.getElementById("porukaKategorija").innerHTML="";
 }

 if (slanjeForme != true) {
 event.preventDefault();
 }

 };
 </script>

</body>
</html>