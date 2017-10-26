<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\InvoicePerformance;
use backend\models\Expenses;
use backend\models\AssetType;
use backend\models\BoilerSum;
use backend\models\Boiler;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoicePerformanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Performances';
$this->params['breadcrumbs'][] = $this->title;
$total_expenses = 0;
$total_cost = 0;
?>
<div class="invoice-performance-index">
<?php $form = ActiveForm::begin(['id' => 'invoice-performance']); ?>

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <div class="box-body">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>


<?php ActiveForm::end(); ?>
</div>
