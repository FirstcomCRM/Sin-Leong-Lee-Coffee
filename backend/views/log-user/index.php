<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LogUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'role',
            'date',
            'time_in',
            'time_out',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
