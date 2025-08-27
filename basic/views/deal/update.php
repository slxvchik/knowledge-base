<?php

use yii\helpers\Html;

$this->title = 'Редактирование сделки: ' . $deal->name;
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $deal->name, 'url' => ['view', 'id' => $deal->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="deal-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contacts' => $contacts,
    ]) ?>
</div>