<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\CustomAsset */
/* @var $form yii\widgets\ActiveForm */

$sin = [
  'Sin Leong Lee'=>'Sin Leong Lee',
];
?>

<div class="custom-asset-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Customer Asset Form</h3>
      </div>
      <div class="box-body">
        <div class="row">

          <div class="col-md-3">
              <?= $form->field($model, 'customer_name')->dropDownList($sin) ?>
          </div>
          <div class="col-md-3">
            <?php echo $form->field($model, 'purchase_date')->widget(DatePicker::classname(), [
                  'convertFormat'=>true,
                  'readonly' => true,
                  'options'=>['id'=>'purchase-date'],
                  'pluginOptions' => [
                      'autoclose'=>true,
                      //  'format' => 'mm/dd/yyyy'
                      'format' => 'php:Y-m-d',
                      ]
            ]); ?>
          </div>
          <div class="col-md-3">
            <?php $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
          </div>

        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        </div>
      </div>
    </div>

    <div class="box box-warning custom-line">
      <div class="box-header with-border">
          <h3 class="box-title">Customer Asset Details </h3>
      </div>
      <div class="box-body">

        <div class="row"><!--Start of boiler details, bolter_no, invoice_no, year, purchase cost--->
            <div class="col-md-3">
                <?= $form->field($model_sum, 'purchase_cost')->textInput(['maxlength' => true, 'id'=>'purchase-cost']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model_sum, 'bolter_no')->textInput(['maxlength' => true])->label() ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model_sum, 'invoice_no')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model_sum, 'depn_rate')->textInput(['id'=>'depn-rate']) ?>
            </div>
          </div><!--End of boiler details, bolter_no, invoice_no, year, purchase cost--->

          <div class="row">
              <div class="col-md-4">
                  <?= $form->field($model_sum, 'total_dep_amount')->textInput(['maxlength' => true, 'id'=>'total_dep_amount']) ?>

                  <?php $form->field($model_sum, 'balance')->textInput(['maxlength' => true, 'id'=>'balance']) ?>
              </div>
          </div>
      </div>
    </div>

    <div class="box box-danger boiler-sum dep-data">
      <div class="box-header with-border">
          <h3 class="box-title">Customer Asset Depreciation </h3>
      </div>
      <div class="box-body">
        <table id ="depreciate" class="table table-bordered">
          <thead>
            <th>Date</th>
            <th>Depreciation Amount</th>
            <th>Net Book Value</th>
          </thead>
            <tbody>
              <?php if (!($model->isNewRecord)): ?>
                <?php foreach ($model_line as $key => $value): ?>
                  <tr>
                    <td><?php echo $form->field($value, 'date_from')->textInput(['maxlength'=>true, 'name'=>'year_list[]'])->label(false) ?></td>
                    <td><?php echo $form->field($value, 'dep_amount')->textInput(['maxlength'=>true, 'name'=>'dep_value[]'])->label(false) ?></td>
                    <td><?php echo $form->field($value, 'dep_expense')->textInput(['maxlength'=>true, 'name'=>'dep_expense[]'])->label(false) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php //endif; ?>
            </tbody>
        </table>
      </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
