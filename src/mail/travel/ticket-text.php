<?php
use yii\helpers\Url;
?>
Travel Ticket
-------------------------------------------
Passenger :
- title : "<?= $bookTitle ?>"
<?php if($bookSubtitle) : ?>
- sub-title : "<?= $bookSubtitle ?>"
<?php endif; ?>

Ticket : <?= $ticketUrl ?>

Have a nice trip !
