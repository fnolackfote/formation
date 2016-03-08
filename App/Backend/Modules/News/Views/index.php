<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 18:05
 */
?>

<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<table>
    <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
    <?php
    foreach ($list_of_news as $news)
    {
        echo '<tr><td>', $news['FNC_fk_FAC'], '</td><td>', $news['FNC_title'], '</td><td>le ', $news['FNC_dateadd']->format('d/m/Y à H\hi'), '</td><td>', ($news['FNC_dateadd'] == $news['FNC_dateedit'] ? '-' : 'le '.$news['FNC_dateedit']->format('d/m/Y à H\hi')), '</td><td><a href="news-update-', $news['FNC_id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['FNC_id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
    }
    ?>
</table>
