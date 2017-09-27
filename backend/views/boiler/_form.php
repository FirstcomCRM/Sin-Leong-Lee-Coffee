<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */
/* @var $form yii\widgets\ActiveForm */


$data = (int)date('Y');
for ($i=$data; $i >=2000 ; $i--) {
  $year_a[] = $i;
  $year_b[] = $i;
}
$year = array_combine($year_a,$year_b);

?>

<div class="boiler-form">
    <?php $form = ActiveForm::begin(); ?>
      <div class="row">
        <div class="col-md-4">
          <?php $form->field($model, 'customer')->dropDownList($customer,['prompt'=>'Select Customer...']) ?>

          <?php echo $form->field($model, 'customer')->widget(Select2::classname(), [
            'data' => $customer,
            'options' => ['placeholder' => 'Select customer ...'],
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]); ?>

          <?= $form->field($model, 'bolter_no')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

          <?php echo $form->field($model, 'pur_date')->widget(DatePicker::classname(), [
                'convertFormat'=>true,
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    //  'format' => 'mm/dd/yyyy'
                    'format' => 'php:Y-m-d',
                  ]
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'pur_cost')->textInput(['maxlength' => true, 'id'=>'purchase-cost', 'onchange'=>'getYear()']) ?>

            <?= $form->field($model, 'cost')->textInput(['maxlength' => true,'onchange'=>'getDepn(), getNbv(), getYear()','id'=>'cost-id']) ?>

            <?= $form->field($model, 'acc_depn')->textInput(['maxlength' => true, 'onchange'=>'getNbv()','id'=>'acc-depn-id']) ?>
        </div>
        <div class="col-md-4">

          <?php echo $form->field($model, 'year')->dropDownList($year,['prompt'=>'Select Year']) ?>

          <?= $form->field($model, 'depn')->textInput(['maxlength' => true, 'readOnly'=>true, 'id'=>'depn-id']) ?>

          <?= $form->field($model, 'nbv')->textInput(['maxlength' => true, 'id'=>'nbv-id', 'readOnly'=>true]) ?>

          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
          </div>
        </div>
      </div>

    <?php ActiveForm::end(); ?>
  <hr>
  <div class="row">
    <div class="col-md-3">
      <label for="">Year from</label>
      <?= Html::dropDownList('year_from', 4 ,$year, ['prompt'=>'Select Year','id'=>'year_from', 'onchange'=>'getYear()', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-3">
      <label for="">Year To</label>
      <?= Html::dropDownList('year_to', 4 ,$year,['prompt'=>'Select Year', 'id'=>'year_to','onchange'=>'getYear()','class'=>'form-control']) ?>
    </div>
  </div>

<br>
  <div class="solution">
    <table id ="depreciate" class="table table-bordered">
      <thead>
        <th>Year</th>
        <th>Depreciation Amount</th>
        <th>Depreciation Expense</th>
      </thead>
        <tbody>

        </tbody>
    </table>
  </div>
</div>
