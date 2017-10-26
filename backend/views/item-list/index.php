<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item',
            'item_name',
            'asset',
            'income',
            // 'exp_cos',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
