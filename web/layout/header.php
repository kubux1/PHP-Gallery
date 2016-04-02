<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Gallery PHP</title>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="Stylesheet" href="../Styl.css" />
    <script type="text/javascript" src="../skrypty/skrypt.js"></script>
    <script type="text/javascript" src="../skrypty/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../skrypty/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../skrypty/jqueryskrypt.js"></script>
    <link rel="stylesheet" href="../css/gallery.css" />
</head>
<body>
    <div id="struktura">
        <div id="naglowek">
            <h1>PIEŚNI LODU I OGNIA</h1>
        </div>

        <div id="stopka">
            <div id="p1">"Valar Morghulis" znaczy wszyscy muszą umrzeć</div>
        </div>

        <div id="nawigacja">
            <h2>Menu: </h2>
            <ul>
                <li>
                    <a href="Rody.html">Rody</a>
                </li>
                <li>
                    <a href="Projekt.html">Projekt</a>
                </li>
                <li>
                    <a href="gallery.php">Galeria</a>
                    <ul>
                    <li><a href="remembered_gallery.php">Galeria zapamiętane</a></li>
                </li></ul>
            </ul>
        </div>