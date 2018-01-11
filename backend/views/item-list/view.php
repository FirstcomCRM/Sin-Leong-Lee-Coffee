<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Item Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-list-view">


    <div class="box box-info">
      <div class="box-body">
        <p>
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
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
                'id',
                'item',
                'item_name',
                'asset',
                'income',
                'exp_cos',
                'inventory_id',
            ],
        ]) ?>
      </div>
    </div>



</div>
