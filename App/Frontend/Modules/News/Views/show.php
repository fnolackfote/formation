<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:45
 */
?>

<p>Par <?php if($user->isAuthenticated()) { ?><a href="/author-<?= $author['FAC_id'] ?>.html"> <?php } ?><b><em><?= $author['FAC_username'] ?></em></b><?php if($user->isAuthenticated()) { ?></a><?php }?>, le <?= $news['FNC_dateadd']->format('d/m/Y à H\hi') ?></p>
<h2 id="news-header"><?= htmlentities($news['FNC_title']) ?></h2>
<p id="news-content"><?= nl2br(htmlentities($news['FNC_content'])) ?></p>

<?php if ($news['FNC_dateadd'] != $news['FNC_dateedit']) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news['FNC_dateedit']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>


<div id="comment-form">
    <form id="form-comment" method="post" action="" data-news="<?= $news->FNC_id() ?>">
        <h3>Nouveau Commentaire</h3>
        <span id="error-span"></span>
        <?= $formComment ?>
        <input id="btn-comment" type="submit" value="Commenter" /> <br />
    </form>
</div>
    <div id="list-comment">
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
            <fieldset class="comment" id="<?= $comment->FCC_id() ?>">
                <legend>
                    Posté par <strong><?= empty($authorComment[$comment->FCC_id()]) ? $comment->FCC_username() : $authorComment[$comment->FCC_id()]->FAC_username() ?></strong> le <?= date_format($comment->FCC_date(), 'd/m/Y à H\hi') ?>
                    <?php if($user->isAuthenticated() && $user->rule() == \Entity\Author::RULE_ADMIN) { ?> -
                        <a class="modif" href="/news-<?= $comment->FCC_fk_FNC() ?>.html">Modifier</a>
                        <a href="admin/comment-delete-<?= $comment->FCC_id() ?>.html">Supprimer</a>
                    <?php } else if($user->isAuthenticated() && $user->sessionUser() == $comment->FCC_fk_FAC()) { ?> -
                        <a href="/news-<?= $comment->FCC_fk_FNC() ?>.html">Modifier</a>
                    <?php } ?>
                </legend>
                <p><?= nl2br(htmlentities($comment->FCC_content())) ?></p>
            </fieldset>
            <?php
        }
    ?>
    </div>

    <noscript>
        <p><a href="/comment-<?= $news['FNC_id'] ?>.html">Ajouter un commentaire</a></p>
    </noscript>
    <script>
        $(document).ready(function() {
            modif();
            refreshComment();
            setVisibleOtherComment();
        });
    </script>



