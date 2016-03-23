<?php

/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 18/03/2016
 * Time: 17:07
 */
$comments_a = [];
//foreach($comment_a as $comment) {
if (isset($comment)) {
    $comment_array['content'] = $comment->FCC_content();
    $comment_array['username'] = $user->isAuthenticated() ? '' : $comment->FCC_username();
    $comment_array['author'] = !empty($user->getAttribute('username')) ? $user->getAttribute('username') : $comment->FCC_username();
    $comment_array['fcc_date'] = date_format(new \DateTime('now', new \DateTimeZone('Europe/Paris')), 'd/m/Y à H\hi');

    $comments_a['comment'][] = $comment_array;
}
else if (isset($error_a)) {
    $comments_a['error_a'] = $error_a;
}
//}
$json = json_encode($comments_a);

//{
//    'comment':
//        {
//            1:{
//                'content':'xxx', 'username':'xxxxx', ...},
//            2:{
//                'content':'xxx', 'username':'xxxxx', ...},
//            3:{
//                'content':'xxx', 'username':'xxxxx', ...},
//            4:{
//                'content':'xxx', 'username':'xxxxx', ...},
//            ...
//        },
//    'error':
//      {
//          1:{ 'content': '......', 'username': '.......'}
//      }
//
//}
//
//data.comment[i].content ==> xxx