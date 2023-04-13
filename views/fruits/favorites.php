<?php
use yii\helpers\Html;

$this->title = 'Favorite Fruits';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Family</th>
            <th>Genus</th>
            <th>Order</th>
            <th>Nutritions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($favoriteFruits as $favorite): ?>
            <tr>
                <td><?= Html::encode($favorite->name) ?></td>
                <td><?= Html::encode($favorite->family) ?></td>
                <td><?= Html::encode($favorite->genus) ?></td>
                <td><?= Html::encode($favorite->order) ?></td>
                <td>
                    <?php $nutrition = json_decode($favorite->nutritions, true) ?>
                    <?php if (!empty($nutrition)): ?>
                        <ul>
                        <?php foreach ($nutrition as $key => $value): ?>
                            <li><?= Html::encode($key) ?>: <?= Html::encode($value) ?></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
