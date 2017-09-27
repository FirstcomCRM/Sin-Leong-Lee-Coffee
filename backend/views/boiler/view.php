<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Boilers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boiler-view">

    <div class="box box-info">

      <div class="box-body">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <h3>Boiler Main</h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                  //  'id',
                    'customer',
                    'bolter_no',
                    'invoice_no',
                    'pur_date',
                    [
                      'attribute'=>'pur_cost',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->pur_cost);
                      }
                    ],

                    [
                      'attribute'=>'cost',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->cost);
                      }
                    ],

                    [
                      'attribute'=>'acc_depn',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->acc_depn);
                      }
                    ],
                    'year',

                    [
                      'attribute'=>'depn',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->depn);
                      }
                    ],

                    [
                      'attribute'=>'nbv',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->nbv);
                      }
                    ],
                ],
            ]) ?>
            <br>

            <h3>Boiler Summary</h3>
            <?= DetailView::widget([
                'model' => $model_sum,
                'attributes' => [
                  //  'id',
                  'boiler_id',
                  'year_from',
                  'year_to',

                  [
                    'attribute'=>'purchase_cost',
                    'value'=>function($model){
                      return Retrieve::retrieveFormat($model->purchase_cost);
                    }
                  ],
                  'total_dep_year',

                  [
                    'attribute'=>'total_dep_amount',
                    'value'=>function($model){
                      return Retrieve::retrieveFormat($model->total_dep_amount);
                    }
                  ],

                  [
                    'attribute'=>'balance',
                    'value'=>function($model){
                      return Retrieve::retrieveFormat($model->balance);
                    }
                  ],
                ],
            ]) ?>

            <h3>Boiler Depreciation</h3>
            <table class="table table-bordered">
              <thead>
                <th>Year</th>
                <th>Depreciation Amount</th>
                <th>Depreciation Expense</th>
              </thead>
              <tbody>
                <?php foreach ($model_line as $key => $value): ?>
                  <tr>
                      <td><?php echo $value->years ?></td>
                      <td><?php echo Retrieve::retrieveFormat($value->dep_amount) ?></td>
                      <td><?php echo Retrieve::retrieveFormat($value->dep_expense) ?></td>
                  </tr>
                <?php endforeach; ?>


              </tbody>
            </table>
      </div>
    </div>



</div>
