<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LogEvent */

$this->title = 'Update Log Event: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Log Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
