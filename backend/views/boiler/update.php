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

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
      </div>
      <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
            'customer'=>$customer
        ]) ?>
      </div>
    </div>


</div>
