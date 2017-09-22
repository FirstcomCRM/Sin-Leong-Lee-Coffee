<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;




/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>
    	
    	<select name="month" class="col-md-2 btn btn-default" required>
	        <option value="">--Select Month--</option>
	        <option value='January'>January</option>
	        <option value='February'>February</option>
	        <option value='March'>March</option>
	        <option value='April'>April</option>
	        <option value='May'>May</option>
	        <option value='June'>June</option>
	        <option value='July'>July</option>
	        <option value='August'>August</option>
	        <option value='September'>September</option>
	        <option value='October'>October</option>
	        <option value='November'>November</option>
	        <option value='December'>December</option>
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
