<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Setup */

$this->title = 'Create Setup';
$this->params['breadcrumbs'][] = ['label' => 'Setups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
