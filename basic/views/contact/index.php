<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="contact-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать контакт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $contacts,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
        'columns' => [
            'id',
            'first_name',
            'second_name',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}'
            ],
        ],
    ]); ?>
</div>