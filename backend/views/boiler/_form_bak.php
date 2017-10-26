<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\AssetType;
/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */
/* @var $form yii\widgets\ActiveForm */


$data = (int)date('Y');
for ($i=$data; $i >=2000 ; $i--) {
  $year_a[] = $i;
  $year_b[] = $i;
}
$year = array_combine($year_a,$year_b);

$file = AssetType::find()->all();
$asset = Arrayhelper::map($file,'id','asset');

?>

<div class="boiler-form">
    <?php $form = ActiveForm::begin(); ?>
      <div class="row">
        <div class="col-md-4">
          <?php $form->field($model, 'customer_name')->dropDownList($customer,['prompt'=>'Select Customer...']) ?>

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
            <?php echo $form->field($model, 'asset_type')->dropDownList($asset,['prompt'=>'Select Asset', 'id'=>'asset-type']) ?>

            <?= $form->field($model, 'pur_cost')->textInput(['maxlength' => true, 'id'=>'purchase-cost', 'onchange'=>'getYear()']) ?>

            <?= $form->field($model, 'cost')->textInput(['maxlength' => true,'onchange'=>'getDepn(), getNbv(), getYear()','id'=>'cost-id']) ?>

            <?= $form->field($model, 'acc_depn')->textInput(['maxlength' => true, 'onchange'=>'getNbv()','id'=>'acc-depn-id']) ?>
        </div>
        <div class="col-md-4">

          <?php echo $form->field($model, 'year')->dropDownList($year,['prompt'=>'Select Year']) ?>

          <?= $form->field($model, 'depn')->textInput(['maxlength' => true, 'readOnly'=>true, 'id'=>'depn-id']) ?>

          <?= $form->field($model, 'nbv')->textInput(['maxlength' => true, 'id'=>'nbv-id', 'readOnly'=>true]) ?>

          <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
          </div>
        </div>
      </div>



<?php if ($model->isNewRecord || $model->asset_type == 1): ?>
  <div class="boiler-file">
      <hr>
    <div class="row">
      <div class="col-md-3">
        <?= $form->field($model_sum, 'purchase_cost')->textInput(['maxlength' => true, 'readOnly'=>true, 'id'=>'purchase-cost-a']) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model_sum, 'year_from')->dropDownList($year,['prompt'=>'Year From', 'id'=>'year_from', 'onchange'=>'getYear()',]) ?>

      </div>
      <div class="col-md-3">
        <?php echo $form->field($model_sum, 'year_to')->dropDownList($year,['prompt'=>'Year to','id'=>'year_to','onchange'=>'getYear()']) ?>

      </div>
    </div>

    <div class="solution">
      <table id ="depreciate" class="table table-bordered">
        <thead>
          <th>Year</th>
          <th>Depreciation Amount</th>
          <th>Depreciation Expense</th>
        </thead>
          <tbody>

              <?php foreach ($model_line as $key => $value): ?>
                <tr>
                  <td><?php echo $form->field($value, 'years')->textInput(['maxlength'=>true, 'name'=>'year_list[]'])->label(false) ?></td>
                  <td><?php echo $form->field($value, 'dep_amount')->textInput(['maxlength'=>true, 'name'=>'dep_value[]'])->label(false) ?></td>
                  <td><?php echo $form->field($value, 'dep_expense')->textInput(['maxlength'=>true, 'name'=>'dep_expense[]'])->label(false) ?></td>
                </tr>
              <?php endforeach; ?>


            <?php //endif; ?>
          </tbody>
      </table>
    </div>

    <div class="row">
      <div class="col-md-3">
          <?= $form->field($model_sum, 'total_dep_year')->textInput(['maxlength' => true,'id'=>'total_dep_year']) ?>
          <?= $form->field($model_sum, 'total_dep_amount')->textInput(['maxlength' => true,'id'=>'total_dep_amount']) ?>
          <?= $form->field($model_sum, 'balance')->textInput(['maxlength' => true,'id'=>'balance']) ?>
      </div>
    </div>

  </div>
<?php endif; ?>


    <?php ActiveForm::end(); ?>
  <hr>

<br>

</div>
