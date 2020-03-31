<?php

use common\services\History\helpers\HistoryEventsHelper;
use yii\helpers\ArrayHelper;

/* @var $model array */
/* @var $oldValue string */
/* @var $newValue string */
/* @var $content string */
?>

    <div class="bg-success ">
        <?php echo HistoryEventsHelper::getEventText($model) . " " .
            "<span class='badge badge-pill badge-warning'>" . ($oldValue ?? "<i>not set</i>") . "</span>" .
            " &#8594; " .
            "<span class='badge badge-pill badge-success'>" . ($newValue ?? "<i>not set</i>") . "</span>";
        ?>

        <span><?=\app\widgets\DateTime\DateTime::widget([
                'dateTime' => ArrayHelper::getValue($model, 'ins_ts')
            ])?></span>
    </div>

<?php
$user = ArrayHelper::getValue($model, ['relations', 'user']);
if (!empty($user)): ?>
    <div class="bg-info"><?=ArrayHelper::getValue($user, 'username')?></div>
<?php endif; ?>

<?php if (isset($content) && $content): ?>
    <div class="bg-info">
        <?php echo $content ?>
    </div>
<?php endif; ?>