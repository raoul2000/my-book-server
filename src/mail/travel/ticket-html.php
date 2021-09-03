<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<h1> Ticket</h1>
<hr />
<p>
    Passenger :
<ul>
    <li>title : "<?= $bookTitle ?>"</li>
    <li><?php if ($bookSubtitle) : ?>
            sub-title : "<?= $bookSubtitle ?>"
        <?php endif; ?></li>
    <li></li>
</ul>

</p>
Ticket : <?= $ticketUrl ?>

Have a nice trip !