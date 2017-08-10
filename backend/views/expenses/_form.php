<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Expenses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expenses-form">

    <?php $form = ActiveForm::begin(); ?>

    <select name="month" class="col-md-2 btn btn-default" required>
	        <option value="">--Select Month--</option>
	        <option value='1'>January</option>
	        <option value='2'>February</option>
	        <option value='3'>March</option>
	        <option value='4'>April</option>
	        <option value='5'>May</option>
	        <option value='6'>June</option>
	        <option value='7'>July</option>
	        <option value='8'>August</option>
	        <option value='9'>September</option>
	        <option value='10'>October</option>
	        <option value='11'>November</option>
	        <option value='12'>December</option>
	    </select>

	    <select name="year" class="col-md-1 btn btn-default" required>
	        <option value="">Year</option>
	                <?php 

	                   for($i = date('Y') ; $i >= 1950; $i--){
	                    //echo "<option value = $i>$i</option>";
	                    ?>
	                      <option value='<?php echo $i;?>'><?php echo $i;?></option>
	                      <?php
	                   }
	                ?>
	    </select>
	    <br><br>
	    <?= $form->field($model, 'file')->fileInput(['required']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
