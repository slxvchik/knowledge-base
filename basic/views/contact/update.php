<?php

use yii\helpers\Html;

$this->title = 'Редактирование контакта: ' . $contact->first_name . ' ' . $contact->second_name;
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $contact->first_name, 'url' => ['view', 'id' => $contact->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="deal-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>