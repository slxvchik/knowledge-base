<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $deal->name;
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="deal-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $deal->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $deal->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот контакт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $deal,
        'attributes' => [
            'id',
            'name',
            'sum',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>