<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AssetType */

$this->title = 'Create Asset Type';
$this->params['breadcrumbs'][] = ['label' => 'Asset Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
