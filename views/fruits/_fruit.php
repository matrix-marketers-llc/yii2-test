<?php
use yii\helpers\Html;
?>
<div class="fruit-item">
    <h3><?= Html::encode($model->name) ?></h3>
    <p>Family: <?= Html::encode($model->family) ?></p>
    <p>Genus: <?= Html::encode($model->genus) ?></p>
    <p>Order: <?= Html::encode($model->order) ?></p>
</div>
