<?php

    $server = 'localhost';
    $user = 'root';
    $pw = '';
    $baza = 'projekt';

    // KONEKCIJA

    $veza = mysqli_connect ($server,$user,$pw,$baza) or die ('Greška spajanja sa bazom !' . mysqli_connect_error());

?>