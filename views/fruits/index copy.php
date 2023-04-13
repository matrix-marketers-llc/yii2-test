<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\helpers\Html;

$url = "";
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchProvider,
    'columns' => [
        ['class' => SerialColumn::class],
        'name',
        'genus',
        'family',
        'order',
        [
            'class' => ActionColumn::class,
            'template' => '{add_to_fav}',
            'buttons' => [
                'add_to_fav' => function ($url, $model, $key) {
                    // $url = Url::to(['fruits/addToFav', 'id' => $model->id]);
                    // return Html::a('Add', $url, ['title' => 'Add To Fav']);
                    return Html::a('Add To Fav', ['addToFav', 'id' => $model->id]);
                },
            ]
        ]
    ]
]);
