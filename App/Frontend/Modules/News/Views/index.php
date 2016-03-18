<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:34
 */
?>

<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<?php
    foreach($list_of_news as $news)
    {
    ?>
        <h2 id="news-header"><a href="news-<?= $news['FNC_id'] ?>.html"><?= htmlentities($news['FNC_title']) ?></a></h2>
        <p id="news-content"><?= nl2br(htmlentities($news['FNC_content'])) ?></p>
    <?php
    }
?>
</body>
</html>
