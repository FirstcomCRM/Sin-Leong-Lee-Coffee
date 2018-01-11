<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\InventoryGroup;
/* @var $this yii\web\View */
/* @var $model backend\models\ItemList */
/* @var $form yii\widgets\ActiveForm */

$data = InventoryGroup::find()->orderBy(['inventory_group'=>SORT_ASC])->all();
$inventory = ArrayHelper::map($data,'id','inventory_group');



?>

<div class="item-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'asset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exp_cos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inventory_id')->dropDownList($inventory) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
