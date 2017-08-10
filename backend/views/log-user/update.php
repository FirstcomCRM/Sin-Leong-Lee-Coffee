<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LogUser */

$this->title = 'Update Log User: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Log Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
