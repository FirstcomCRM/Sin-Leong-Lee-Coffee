<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model backend\models\DirectExpense */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Direct Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direct-expense-view">

    <p class="text-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

          [
            'attribute'=>'expense_type',
            'value'=>function($model){
              return Retrieve::retrieveAsset($model->expense_type);
            }
          ],
            'customer_name',
            'date',
            [
              'attribute'=>'expenses',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->expenses);
              },
            ],

        ],
    ]) ?>

</div>
