<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                  //  'id',
                    'customer',
                    'bolter_no',
                    'invoice_no',
                    'pur_date',
                    'pur_cost',
                    'cost',
                    'acc_depn',
                    'year',
                    'depn',
                    'nbv',
                ],
            ]) ?>
      </div>
    </div>



</div>
