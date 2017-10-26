<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Account Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'account',
            'account_details',
        ],
    ]) ?>

</div>
