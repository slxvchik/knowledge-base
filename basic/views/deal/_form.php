<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="deal-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'sum')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'contact_ids')->checkboxList(
        ArrayHelper::map($contacts, 'id', function ($contact) {
            return $contact['first_name'] . ' ' . $contact['second_name'] . '(id: ' . $contact['id'] . ')';
        }),
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>