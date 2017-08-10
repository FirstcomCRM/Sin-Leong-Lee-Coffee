<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\LogEvent */

$this->title = 'Create Log Event';
$this->params['breadcrumbs'][] = ['label' => 'Log Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
