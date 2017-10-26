<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
use backend\models\AssetType;
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
                    'customer_name',
                  /*  [
                      'attribute'=>'asset_type',
                      'value'=>function($model){
                        return Retrieve::retrieveAsset($model->asset_type);
                      },
                    ],*/
                    'purchase_date',
                    [
                      'attribute'=>'amount',
                      'value'=>function($model){
                          return Retrieve::retrieveFormat($model->amount);
                      }
                    ],
                ],
            ]) ?>
            <br>

      </div>
    </div>



</div>
