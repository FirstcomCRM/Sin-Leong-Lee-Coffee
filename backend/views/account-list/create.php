<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AccountList */

$this->title = 'Create Account List';
$this->params['breadcrumbs'][] = ['label' => 'Account Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
