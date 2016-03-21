<?php

/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 18/03/2016
 * Time: 17:07
 */
$comments_a = [];

$comment_array['content'] = $comment->FCC_content();
$comment_array['username'] = $user->isAuthenticated() ? '' : $comment->FCC_username();
$comment_array['email'] = $user->isAuthenticated() ? '' : $comment->FCC_email();
$comment_array['fcc_fk_fac'] = $user->isAuthenticated() ? $user->sessionUser() : '';
$comment_array['author'] = !empty($user->getAttribute('username')) ? $user->getAttribute('username') : $comment->FCC_username();
//$comment_array['fcc_fk_fnc'] = $news->FNC_id();
$comment_array['fcc_fk_fnc'] = '';
$comment_array['fcc_date'] = date_format(new \DateTime('now', new \DateTimeZone('Europe/Paris')), 'd/m/Y à H\hi');

$comments_a['comment'][] = $comment_array;

$json = json_encode($comments_a);


//$comments_a = [];
//$comments_a['commentaires'][] = $comment_array;
//
//$json = json_encode($comments_a);

?>