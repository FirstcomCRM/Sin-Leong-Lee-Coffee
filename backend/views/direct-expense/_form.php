<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use backend\models\AssetType;
use backend\models\InvoicePerformance;
/* @var $this yii\web\View */
/* @var $model backend\models\DirectExpense */
/* @var $form yii\widgets\ActiveForm */

$file = AssetType::find()->orderBy(['asset'=>SORT_ASC])->asArray()->all();
$asset = Arrayhelper::map($file,'id','asset');

$file = InvoicePerformance::find()->orderBy(['customer_name'=>SORT_ASC])->distinct()->all();
$cust = ArrayHelper::map($file,'customer_name','customer_name');
//print_r($cust);
?>

<div class="direct-expense-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'expense_type')->dropDownList($asset) ?>

    <?= $form->field($model, 'customer_name')->dropDownList($cust) ?>

    <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
          'convertFormat'=>true,
          'readonly' => true,
          'pluginOptions' => [
              'autoclose'=>true,
              //  'format' => 'mm/dd/yyyy'
              'format' => 'php:Y-m-d',
              ]
    ]); ?>

    <?= $form->field($model, 'expenses')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
