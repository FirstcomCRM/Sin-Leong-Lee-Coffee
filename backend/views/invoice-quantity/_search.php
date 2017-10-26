<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\InvoicePerformance;
/* @var $this yii\web\View */
/* @var $model backend\models\InvoiceQuantitySearch */
/* @var $form yii\widgets\ActiveForm */
//$data = [
//  'customer1'=>'Customer1',
  //'customer2'=>'Customer2',
//];

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

<div class="invoice-quantity-search">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
      //'method' => 'post',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
         <?php  echo $form->field($model,'month_from')->label(false)->widget(Select2::className(),[
            'data'=>$months,
            'options'=>['placeholder'=>'Month From '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">

        <?php echo $form->field($model,'year_from')->label(false)->widget(Select2::className(),[
           'data'=>$years,
          'options'=>['placeholder'=>'Year From '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
      </div>
      <div class="col-md-3">
        <?php  echo $form->field($model,'month_to')->label(false)->widget(Select2::className(),[
           'data'=>$months,
           'options'=>['placeholder'=>'Month To '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
      </div>
      <div class="col-md-3">

           <?php echo $form->field($model,'year_to')->label(false)->widget(Select2::className(),[
              'data'=>$years,
              'options'=>['placeholder'=>'Year To '],
              'theme'=> Select2::THEME_BOOTSTRAP,
              'size'=> Select2::MEDIUM,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'customer_name')->label(false)->widget(Select2::className(),[
           'data'=>$cust,
           'options'=>['placeholder'=>'Customer Name','class'=>'qty-invoice'],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>

      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
         <?= $form->field($model, 'item_code')->textInput(['placeholder'=>'Item Code' ])->label(false) ?>
      </div>
      <div class="col-md-3">
           <?= $form->field($model, 'item_name')->textInput(['placeholder'=>'Item Name'])->label(false) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
