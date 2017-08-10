<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LogEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'role',
            'date',
            'module',
            // 'event',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
