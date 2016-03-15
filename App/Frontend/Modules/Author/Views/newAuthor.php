<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 15:32
 */
?>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<h2>Inscription d'un nouvel auteur</h2>
<form action="" method="post">
    <p>
        <?= isset($errorPass) ? $errorPass : "" ?>
        <?= $formNewAuthor ?>

        <input type="submit" value="Valider" />
    </p>
</form>
</body>
</html>