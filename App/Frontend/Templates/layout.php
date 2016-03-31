<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 10:36
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= isset($title) ? $title : 'Mon super site' ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script type="text/javascript" src="/js/allFunctions.js"></script>
    </head>

    <body>
        <div id="wrap">
            <header>
                <h1><a href="/">Mon super site</a></h1>
                <p>Comment ca, il n'y a presque rien ?</p>
            </header>
            <nav>
                <ul>
                    <?php foreach($menu as $key => $link) { ?>
                        <li><a href="<?= $link ?>"><?= $key ?></a></li>
                    <?php } ?>
                </ul>
            </nav>

            <div id="content-wrap">
                <section id="main">
                    <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
                    <?php /** @var \OCFram\Page $content */ ?>
                    <?= $content ?>
                </section>
                <div id="content-user-master">
                    <p id="content-user"> <?=  !empty($user->getAttribute('username')) ? $user->getAttribute('username') : '' ?></p>
                    <p id="content-rule"><?= !empty($user->getAttribute('rule')) ? '(ADMIN)' : '' ?></p>
                </div>
            </div>

            <footer></footer>
        </div>
    </body>
</html>
