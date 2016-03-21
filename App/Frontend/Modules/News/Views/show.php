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


<div id="comment-form">
    <form id="form-comment" method="post" action="" data-news="<?= $news->FNC_id() ?>">
        <h3>Nouveau Commentaire</h3>
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
            <fieldset>
                <legend>
                    Posté par <strong><?= empty($authorComment[$comment->FCC_id()]) ? $comment->FCC_username() : $authorComment[$comment->FCC_id()]->FAC_username() ?></strong> le <?= date_format($comment->FCC_date(), 'd/m/Y à H\hi') ?>
                    <?php if($user->isAuthenticated() && $user->rule() == \Entity\Author::RULE_ADMIN) { ?> -
                        <?php if($user->sessionUser() == $comment->FCC_fk_FAC()){ ?>
                            <a href="/news-<?= $comment->FCC_fk_FNC() ?>.html">Modifier</a>
                        <?php } ?>
                        <a href="admin/comment-delete-<?= $comment->FCC_id() ?>.html">Supprimer</a>
                    <?php } else if($user->isAuthenticated() && $user->sessionUser() == $comment->FCC_fk_FAC()) { ?> -
                        <a href="/news-<?= $comment->FCC_fk_FNC() ?>.html">Modifier</a>
                    <?php } ?>
                </legend>
                <p><?= nl2br(htmlspecialchars($comment->FCC_content())) ?></p>
            </fieldset>
            <?php
        }
    ?>
    </div>

    <noscript>
        <p><a href="/comment-<?= $news['FNC_id'] ?>.html">Ajouter un commentaire</a></p>
    </noscript>
    <script>
        $(document).ready( function() {
//            alert($('#form-comment').data('news'));
//            return false;
            $('#form-comment').submit( function(e) {
                e.preventDefault();
                var content = $(this).find("textarea[name='FCC_content']").val();
                var username = $(this).find("input[name='FCC_username']").val();
                var email = $(this).find("input[name='FCC_email']").val();
                if(content === '' || username === '') {
                    return false;
                }
                $.post(
                    '/testJson',
                    {
                        'FCC_content':content,
                        'FCC_username':username,
                        'FCC_email':email,
                        'FCC_fk_FNC': $(this).data('news'),
                    },
                    function(data) {
                        $('#list-comment').load(window.location + ' #list-comment');
                        for (var i= 0; i<data.comment.length; i++) {
                            alert($(this).data('news'));
                            //$('#list-comment').prepend('<fieldset><legend>Posté par <b>' + data.comment[i].author + '</b> le ' + data.comment[i].fcc_date + '</legend><p>' + data.comment[i].content + '</p></fieldset>');
                        }
//                        $('#list-comment').append().html('<fieldset><legend>' + data.comment[0].fcc_fk_fac) + '</legend>' + data.comment[0].content + '</fieldset>'));
//                        $('#list-comment').append($('<fieldset></fieldset>').text(data.comment[0].content));
                        console.log(data);
//                        $('#list-comment').append($('<legend></legend>').text(data.comment[0].content));
                        //$('#comment-form').load(window.location + ' #comment-form');
                        $(this).find("textarea[name='FCC_content']").val('');

                    },
                    'json'
                );
    //            return false;
            });
        });
    </script>
</body>
</html>