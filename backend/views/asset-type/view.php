<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AssetType */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asset Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-type-view">

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
                'id',
                'asset',
            ],
        ]) ?>
      </div>
    </div>

</div>
