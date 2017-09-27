<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\InvoicePerformance */

$this->title = 'Create Invoice Performance';
$this->params['breadcrumbs'][] = ['label' => 'Invoice Performances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-performance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
      
    ]) ?>

</div>
