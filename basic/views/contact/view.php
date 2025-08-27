<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $contact->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="contact-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $contact->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $contact->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот контакт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $contact,
        'attributes' => [
            'id',
            'first_name',
            'second_name',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'label' => 'Сделки',
                'value' => implode(', ', ArrayHelper::getColumn($contact->deals, 'name')),
                'visible' => !empty($contact->deals),
            ]
        ],
    ]) ?>
</div>