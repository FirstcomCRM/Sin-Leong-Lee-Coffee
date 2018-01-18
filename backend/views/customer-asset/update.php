<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomAsset */

$this->title = 'Update Custom Asset: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Custom Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="custom-asset-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_sum'=>$model_sum,
        'model_line'=>$model_line,
    ]) ?>

</div>
