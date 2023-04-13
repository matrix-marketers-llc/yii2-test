<?php
// views/fruit/index.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Fruits;

/* @var $this yii\web\View */
/* @var $models app\models\Fruit[] */
/* @var $pages yii\data\Pagination */
/* @var $name string */
/* @var $family string */

$this->title = 'All Fruits';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $model = new Fruits(); ?>
<?php $form = ActiveForm::begin(['action'=>'index.php?r=fruits/index','method' => 'get']); ?>
<div class="row mb-3">
    <div class="col-lg-3">
        <?= $form->field($model, 'name')->textInput(['value' => $name])->label('Filter by name') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'family')->textInput(['value' => $family])->label('Filter by family') ?>
    </div>
    <div class="col-lg-3">
        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px;']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Family</th>
            <th>Genus</th>
            <th>Order</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model): ?>
            <tr>
                <td><?= Html::encode($model->name) ?></td>
                <td><?= Html::encode($model->family) ?></td>
                <td><?= Html::encode($model->genus) ?></td>
                <td><?= Html::encode($model->order) ?></td>
                <td>
                    <?php if($model->is_favorite): ?>
                        <?= Html::a('Remove from favorites', ['fruits/unfavorite', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                    <?php else: ?>
                        <?= Html::a('Add to fav', ['fruits/favorite', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= LinkPager::widget(['pagination' => $pages]) ?>