<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AssetType;
use backend\models\InvoicePerformance;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\BoilerSearch */
/* @var $form yii\widgets\ActiveForm */
$customer = ArrayHelper::map(InvoicePerformance::find()->select('customer_name')->orderBy(['customer_name'=>SORT_ASC])->distinct()->all(), 'customer_name', 'customer_name');
$file = AssetType::find()->orderBy(['id'=>SORT_DESC])->all();
$asset = Arrayhelper::map($file,'id','asset');

?>

<div class="boiler-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-4">
        <?php echo $form->field($model, 'customer_name')->widget(Select2::classname(), [
          'data' => $customer,
        //  'options' => ['placeholder' => 'Select customer ...'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
