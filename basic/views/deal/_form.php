<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="deal-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'sum')->textInput(['maxlength' => true]); ?>
<!--     //= $form->field($model, 'contacts')->textInput(['maxlength' => true]); ?>-->

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>