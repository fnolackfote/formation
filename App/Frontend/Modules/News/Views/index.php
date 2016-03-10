<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:34
 */

foreach($list_of_news as $news)
{
?>
    <h2><a href="news-<?= $news['FNC_id'] ?>.html"><?= $news['FNC_title'] ?></a></h2>
    <p><?= nl2br($news['FNC_content']) ?></p>
<?php
}