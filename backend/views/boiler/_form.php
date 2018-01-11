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


function custom_sort( $array )
{
  // Sort it
  asort($array);
  // return sorted array
  return $array;
}

$data = (int)date('Y');
for ($i=$data; $i >=2010 ; $i--) {
  $year_a[] = $i;
  $year_b[] = $i;
}
$year = array_combine($year_a,$year_b);

$file = AssetType::find()->orderBy(['id'=>SORT_DESC])->where(['asset'=>'Boiler'])->all();
$asset = Arrayhelper::map($file,'id','asset');

$date_to = [
  $model_sum->date_to=>$model_sum->date_to,
];

$date_from = [
  $model_sum->date_from=>$model_sum->date_from,
];

$sin = [
  'Sin Leong Lee'=>'Sin Leong Lee',
];
$customer = array_merge($customer, $sin);
$customer = custom_sort($customer);

//$customer[] = 'Sin Leeong Lee'=>'Sin Leeong Lee';
?>


<style>
.field-asset-type{
  display:none;
}/*Note, asset type hide it for now since Asset type rendered dumb and useless*/

</style>


<div class="boiler-form"> <!--Start of Boiler Form-->
    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-info"> <!---Start of Main Boiler Box---->
      <div class="box-header with-border">
          <h3 class="box-title">Main Boiler Form</h3>
      </div>
      <div class="box-body"><!--Start of main boiler inputs--->
        <div class="row">
          <div class="col-md-3"><!--Asset Type-->
            <?php echo $form->field($model, 'customer_name')->widget(Select2::classname(), [
              'data' => $customer,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]); ?>
          </div><!--Asset Type-->
          <div class="col-md-3"><!--customer name-->
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
          </div><!--customer name-->
          <div class="col-md-3"><!--Purchase Date-->
              <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
          </div><!--Purchase Date-->
          <div class="col-md-3"><!--Amount-->

          </div><!--Amount-->
        </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            </div>
      </div><!--End of main boiler inputs--->
    </div><!---End of Main Boiler Box---->



    <div class="box box-warning boiler-sum"><!---Start of Boiler Details---->
      <div class="box-header with-border">
          <h3 class="box-title">Boiler Details </h3>
      </div>
      <div class="box-body"><!---Start of Boiler Details box body---->

        <div class="row"><!--Start of boiler details, bolter_no, invoice_no, year, purchase cost--->
          <div class="col-md-3">
              <?= $form->field($model_sum, 'purchase_cost')->textInput(['maxlength' => true, 'id'=>'purchase-cost']) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model_sum, 'bolter_no')->textInput(['maxlength' => true])->label('Boiler No') ?>
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

      </div><!---End of Boiler Details box body---->
    </div><!---End of Boiler Details---->

    <div class="box box-danger boiler-sum dep-data">
      <div class="box-header with-border">
          <h3 class="box-title">Boiler Depreciation </h3>
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



</div><!--End of Boiler Form-->
