<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 09/03/2016
 * Time: 18:33
 */
?>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<h2>Detail de l'utilisateur <b> <?= $author['FAC_username'] ?></b></h2>
<hr />
<u><h3>Informations Personnelles</h3></u>
<p><b>Nom : </b><?= $author['FAC_lastname'] ?><br />
<p><b>Prenom : </b><?= $author['FAC_firstname'] ?><br />
<p><b>Email : </b><?= !empty($author['FAC_email']) ? $author['FAC_email'] : '<i>aucun mail renseigne</i>'?><br />
<hr />
<u><h3>Liste des news publiées</h3></u>
<?php
    foreach($news_author_a as $news)
    {
    ?>
    <h3><?= $news['FNC_title'] ?>&nbsp;&nbsp; <sub>Ajoute le <?= date_format($news->FNC_dateadd(), 'd/m/Y à H:i') ?> - Dernere modification le <?= date_format($news->FNC_dateedit(), 'd/m/Y à H:i') ?>  </sub></h3>
    <p><?= nl2br($news['FNC_content']) ?></p>
<?php
}
?>
<hr />
<u><h3>Liste des Commentaires publiés</h3></u>
<?php
foreach($comment_author_a as $comment)
{
    ?>
    <p><?= nl2br($comment['FCC_content']) ?>&nbsp;&nbsp;<sub><?= date_format($comment->FCC_date(), 'd/m/Y à H:i') ?></sub></p>
    <?php
}
?>
</body>
</html>
