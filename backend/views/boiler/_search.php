<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BoilerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="boiler-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer') ?>

    <?= $form->field($model, 'bolter_no') ?>

    <?= $form->field($model, 'invoice_no') ?>

    <?= $form->field($model, 'pur_date') ?>

    <?php // echo $form->field($model, 'pur_cost') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'acc_depn') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'depn') ?>

    <?php // echo $form->field($model, 'nbv') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
