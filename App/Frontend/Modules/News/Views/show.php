<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:45
 */
?>

<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<p>Par <?php if($user->isAuthenticated()) { ?><a href="/author-<?= $author['FAC_id'] ?>.html"> <?php } ?><b><em><?= $author['FAC_username'] ?></em></b><?php if($user->isAuthenticated()) { ?></a><?php }?>, le <?= $news['FNC_dateadd']->format('d/m/Y à H\hi') ?></p>
<h2 id="news-header"><?= htmlentities(trim($news['FNC_title'])) ?></h2>
<p id="news-content"><?= nl2br(htmlentities(trim($news['FNC_content']))) ?></p>

<?php if ($news['FNC_dateadd'] != $news['FNC_dateedit']) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news['FNC_dateedit']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>
<?php
if (empty($comments))
{
    ?>
    <p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
    <?php
}
foreach($comments as $comment)
{
    ?>
    <fieldset>
        <legend>
            Posté par <strong><?= empty($authorComment[$comment->FCC_id()]) ? $comment->FCC_username() : $authorComment[$comment->FCC_id()]->FAC_username() ?></strong> le <?= date_format($comment->FCC_date(), 'd/m/Y à H\hi') ?>
            <?php if($user->isAuthenticated() && $user->rule() == \Entity\Author::RULE_ADMIN) { ?> -
                <?php if($user->sessionUser() == $comment->FCC_fk_FAC()){ ?>
                    <a href="admin/comment-update-<?= $comment->FCC_id() ?>.html">Modifier</a>
                <?php } ?>
                <a href="admin/comment-delete-<?= $comment->FCC_id() ?>.html">Supprimer</a>
            <?php } else if($user->isAuthenticated() && $user->sessionUser() == $comment->FCC_fk_FAC()) { ?> -
                <a href="admin/comment-update-<?= $comment->FCC_id() ?>.html">Modifier</a>
            <?php } ?>
        </legend>
        <p><?= nl2br(htmlentities($comment->FCC_content())) ?></p>
    </fieldset>
    <?php
}
?>

<div id="comment-form"></div>

<?php
    //require_once 'insertComment.php';
?>
<p><a href="/comment-<?= $news['FNC_id'] ?>.html">Ajouter un commentaire</a></p>
    <script>
        /*$(document).ready(function(){
            $.post()
        });*/
        $.post(
            '/testJson',
            false,
            function(data) {
                $('#comment-form').html(data);
        },
        'html'
        );
    </script>
</body>
</html>