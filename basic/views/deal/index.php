<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Сделки';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="deal-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать сделку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $deals,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
        'columns' => [
            'id',
            'name',
            'sum',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}'
            ],
        ],
    ]); ?>
</div>