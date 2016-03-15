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
    <h3 id="news-header" class="detail-news-header"><?= $news['FNC_title'] ?></h3>
    <p class="date-content" class="detail-news-content">Ajoute le <?= date_format($news->FNC_dateadd(), 'd/m/Y à H:i') ?> - Dernere modification le <?= date_format($news->FNC_dateedit(), 'd/m/Y à H:i') ?>  </p>
    <p id="news-content"><?= nl2br($news['FNC_content']) ?></p>
<?php
}
?>
<hr />
<u><h3>Liste des Commentaires publiés</h3></u>
<?php
foreach($comment_author_a as $comment)
{
    ?>
    <p class="detail-comment-date"><?= date_format($comment->FCC_date(), 'd/m/Y à H:i') ?></p>
    <p id="comment-content" class="detail-comment-content"><?= nl2br($comment['FCC_content']) ?></p>
    <?php
}
?>
</body>
</html>
