<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\LogUser */

$this->title = 'Create Log User';
$this->params['breadcrumbs'][] = ['label' => 'Log Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
