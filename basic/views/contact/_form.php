<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="contact-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]); ?>
<!--     //= $form->field($model, 'contacts')->textInput(['maxlength' => true]); ?>-->

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>