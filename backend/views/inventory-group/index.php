<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InventoryGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Inventory Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'inventory_group',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
