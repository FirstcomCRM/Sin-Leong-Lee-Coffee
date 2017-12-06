<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AssetType;
use backend\models\InvoicePerformance;
/* @var $this yii\web\View */
/* @var $model backend\models\DirectExpenseSearch */
/* @var $form yii\widgets\ActiveForm */

$file = AssetType::find()->orderBy(['asset'=>SORT_ASC])->asArray()->all();
$asset = Arrayhelper::map($file,'id','asset');

$file = InvoicePerformance::find()->orderBy(['customer_name'=>SORT_ASC])->distinct()->all();
$cust = ArrayHelper::map($file,'customer_name','customer_name');
?>

<div class="direct-expense-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-3">
        <?= $form->field($model, 'expense_type')->dropDownList($asset,['prompt'=>'Expense Type'])->label(false) ?>
      </div>
      <div class="col-md-3">
        <?= $form->field($model, 'customer_name')->dropDownList($cust, ['prompt'=>'Customer Name'])->label(false) ?>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
