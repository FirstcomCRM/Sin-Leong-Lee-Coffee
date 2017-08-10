<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Expenses */

$this->title = 'Create Expenses';
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-create">

    <div class="box box-info">
    	<div class="box-header with-border">
    		<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    	</div>
		<div class="box-body">

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>

</div>
