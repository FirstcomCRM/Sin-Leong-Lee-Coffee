<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SetupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Setup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php Html::a('Create Setup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    //    'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'up',
            'down',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
