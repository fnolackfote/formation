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
    <p>Par <em><?= $news['FNC_fk_FAC'] ?></em>, le <?= $news['FNC_dateadd']->format('d/m/Y à H\hi') ?></p>
    <?php if ($news['FNC_dateadd'] != $news['dateedit']) { ?>
    <p style="text-align: right;"><small><em>Modifiée le <?= $news['FNC_dateedit']->format('d/m/Y à H\hi') ?></em></small></p>
    <?php
    }
}