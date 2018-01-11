<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\InventoryGroup */

$this->title = 'Create Inventory Group';
$this->params['breadcrumbs'][] = ['label' => 'Inventory Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
