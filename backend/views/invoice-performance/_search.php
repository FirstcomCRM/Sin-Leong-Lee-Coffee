<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\InvoicePerformance;

/* @var $this yii\web\View */
/* @var $model backend\models\InvoicePerformanceSearch */
/* @var $form yii\widgets\ActiveForm */
$months = [
  'January'=>'January',
  'February'=>'February',
  'March'=>'March',
  'April'=>'April',
  'May'=> 'May',
  'June'=>'June',
  'July'=>'July',
  'August'=>'August',
  'September'=>'September',
  'October'=>'October',
  'November'=>'November',
  'December'=>'December',
];
$info = (int)date('Y');
for ($i=$info; $i >=2000 ; $i--) {
  $year_a[] = $i;
  $year_b[] = $i;
}
$years = array_combine($year_a,$year_b);

$data = InvoicePerformance::find()->select(['customer_name'])->orderBy(['customer_name'=>SORT_ASC])->all();
$cust = ArrayHelper::map($data,'customer_name','customer_name');

?>

<div class="invoice-performance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
      //  'method' => 'get',
        'method' => 'post',
    ]); ?>
    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'month_from')->dropDownList($months) ?>
      </div>
      <div class="col-md-3">
         <?php echo $form->field($model,'year_from')->dropDownList($years) ?>
      </div>
      <div class="col-md-3">
          <?php echo $form->field($model,'month_to')->dropDownList($months) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'year_to')->dropDownList($years) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <?php echo $form->field($model,'customer_name')->dropDownList($cust) ?>
      </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'formtarget'=>'_blank']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
