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
        <title>
            <?php /** @var string $title */ ?>
            <?= isset($title) ? $title : 'Mon super site' ?></title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
    </head>

    <body>
        <div id="wrap">
            <header>
                <h1><a href="/">Mon super site</a></h1>
                <p>Comment ca, il n'y a presque rien ?</p>
            </header>

            <nav>
                <ul>
                    <li><a href="/">Accueil</a></li>
                    <?php /** @var \OCFram\User $user */ ?>
                    <?php if($user->isAuthenticated()) { ?>
                    <li><a href="/admin/">Admin</a></li>
                    <li><a href="/admin/news-insert.html">Ajouter une news</a></li>
                    <li><a href="/admin/">Deconnecter</a></li>
                    <?php } ?>
                </ul>
            </nav>

            <div id="content-wrap">
                <section id="main">
                    <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
                     <?php /** @var \OCFram\Page $content */ ?>
                    <?= $content ?>
                </section>

            </div>

            <footer></footer>
        </div>
    </body>

</html>
