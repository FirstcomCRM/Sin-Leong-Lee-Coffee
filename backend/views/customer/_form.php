<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InvoicePerformance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-performance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'average_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sales_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_card_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_item_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
