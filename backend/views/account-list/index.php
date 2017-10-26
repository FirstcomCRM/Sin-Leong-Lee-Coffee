<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Account List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        //    'id',
            'account',
            'account_details',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
