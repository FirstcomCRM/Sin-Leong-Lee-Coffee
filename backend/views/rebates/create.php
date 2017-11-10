<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rebates */

$this->title = 'Create Rebates';
$this->params['breadcrumbs'][] = ['label' => 'Rebates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rebates-create">

    <h1><?php Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
