<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CustomAsset */

$this->title = 'Create Custom Asset';
$this->params['breadcrumbs'][] = ['label' => 'Custom Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-asset-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_sum'=>$model_sum,
        'model_line'=>$model_line,
    ]) ?>

</div>
