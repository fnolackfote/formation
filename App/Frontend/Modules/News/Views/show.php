<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:45
 */
?>

<p>Par <em><?= $news['author'] ?></em>, le <?= $news['dateadd']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['title'] ?></h2>
<p><?= nl2br($news['content']) ?></p>

<?php if ($news['dateadd'] != $news['dateedit']) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news['dateedit']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>

<p><a href="comment-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>

<?php
if (empty($comments))
{
    ?>
    <p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
    <?php
}

foreach ($comments as $comment)
{
    ?>
    <fieldset>
        <legend>
            Posté par <strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['date']->format('d/m/Y à H\hi') ?>
            <?php if($user->isAuthentificated()) { ?> -
                <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
                <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
            <?php } ?>
        </legend>
        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
    </fieldset>
    <?php
}
?>

<p><a href="comment-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>