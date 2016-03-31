<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 22/03/2016
 * Time: 16:21
 */
if(isset($comment_a)) {
    $comments_a = [];

    foreach ($comment_a as $comment) {
        $link_a = [];
        if ($user->isAuthenticated() && $user->rule() == \Entity\Author::RULE_ADMIN) {
            $link_a[] = '<a class="modif" href="">Modifier</a>';
            $link_a[] = '<a href="admin/comment-delete-' . $comment->FCC_id() . '.html">Supprimer</a>';
        } else if ($user->isAuthenticated() && $user->sessionUser() == $comment->FCC_fk_FAC()) {
            $link_a[] = '<a class="modif" href="">Modifier</a>';
        }

        $comment_array['content'] = $comment->FCC_content();
        $comment_array['username'] = $comment->FCC_username();
        $comment_array['fcc_id'] = $comment->FCC_id();
        $comment_array['author'] = empty($authorComment[$comment->FCC_id()]) ? $comment->FCC_username() : $authorComment[$comment->FCC_id()]->FAC_username();
        $comment_array['fcc_date'] = date_format($comment->FCC_date(), 'd/m/Y à H\hi');

        $comments_a['comment'][] = $comment_array;
        $comments_a['link_a'][] = $link_a;
    }

    $json = json_encode($comments_a);
}