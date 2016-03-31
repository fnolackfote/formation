<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 18/03/2016
 * Time: 17:07
 */

$comments_a = [];
$link_a=[];

//foreach($comment_a as $comment) {
if (isset($comment)) {
    //j'ai pas le FCC_fk_FAC dans comment.
    if($user->isAuthenticated()) {
        $link_a[] = '<a class="modif" href="">Modifier</a>';
        if ($user->rule() == \Entity\Author::RULE_ADMIN) {
            $link_a[] = '<a href="admin/comment-delete-'.$comment->id().'.html">Supprimer</a>';
        }
    }

    $comment_array['content'] = $comment->FCC_content();
    $comment_array['fcc_id'] = $comment->id();

    $comment_array['username'] = $user->isAuthenticated() ? '' : $comment->FCC_username();
    $comment_array['author'] = !empty($user->getAttribute('username')) ? $user->getAttribute('username') : $comment->FCC_username();
    $comment_array['fcc_date'] = date_format(new \DateTime('now', new \DateTimeZone('Europe/Paris')), 'd/m/Y à H\hi');

    $comments_a['comment'][] = $comment_array;
}
else if (isset($error_a)) {
    $comments_a['error_a'] = $error_a;
}
$comments_a['link_a'] = $link_a;

$json = json_encode($comments_a);
