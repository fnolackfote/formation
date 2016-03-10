<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:45
 */
?>

<p>Par <a href="/author-<?= $author['FAC_id'] ?>.html"><b><em><?= $author['FAC_username'] ?></em></b></a>, le <?= $news['FNC_dateadd']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['FNC_title'] ?></h2>
<p><?= nl2br($news['FNC_content']) ?></p>

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
            Posté par <strong><?= $user->isAuthenticated() ? $author['FAC_username'] : (empty($authorComment[$comment->FCC_id()]) ? $comment->FCC_email() : $authorComment[$comment->FCC_id()]->FAC_username()) ?></strong> le <?= date_format($comment->FCC_date(), 'd/m/Y à H\hi') ?>
            <?php if($user->isAuthenticated() && $user->sessionUser() == $author->FAC_id()) { ?> -
                <a href="admin/comment-update-<?= $comment->FCC_id() ?>.html">Modifier</a> |
                <a href="admin/comment-delete-<?= $comment->FCC_id() ?>.html">Supprimer</a>
            <?php } ?>
        </legend>
        <p><?= nl2br(htmlspecialchars($comment->FCC_content())) ?></p>
    </fieldset>
    <?php
}
?>

<p><a href="comment-<?= $news['FNC_id'] ?>.html">Ajouter un commentaire</a></p>