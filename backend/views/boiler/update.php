<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Boiler */

$this->title = 'Update Boiler: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Boilers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="boiler-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_sum'=>$model_sum,
        'model_line'=>$model_line,
        'customer'=>$customer
    ]) ?>
</div>
