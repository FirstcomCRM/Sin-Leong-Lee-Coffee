<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Permission */


$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="permission-update">


    <?php $form = ActiveForm::begin(); ?>   
    <?php

 

    $array = array();
    foreach ($user as $key => $value) {
    	$array[$value['controller']] = array();
    	foreach (explode(',', $value['permission']) as $value2) {
    		array_push($array[$value['controller']],$value2);
    	}
    }
  

    ?>
    <select name="role" class="col-md-3 btn btn-default" id="year" required>
        
        <option value='<?php echo $user[0]['id'];?>' selected="selected"><?php echo ucfirst($user[0]['user_role']);?></option>
        
    </select>
    <br>
    <br>
    <?php
        foreach ($fulllist as $key => $value) {
            preg_match('/(.*)Controller/', $key, $display);
            if($display[1] != 'Site'){
            
    ?>

                <div class="col-md-3"><input type="checkbox" onchange="checkAll('<?= $display[1]; ?>')" id="<?= $display[1]; ?>" name="controller[]" value="<?= $display[1]; ?>"><strong><?= $display[1]; ?></strong><ul style="list-style: none;">
        <?php
                foreach ($value as $value2) {
        ?>
                    <li><input type="checkbox" onchange="checkSub('<?= $display[1]; ?>')" class="<?= $display[1]; ?>" name="permission[]" value="<?= $display[1].'-'.$value2; ?>" 
                    <?php
                    	foreach ($user as  $value4) {
                    		if($value4['controller'] == $display[1]){
                    			foreach ($array[$display[1]] as $value3) {
			                    	if($value3 == $value2){
			                    		echo 'checked';
			                    	}
			                    }
                    		}
                    	}

	                    


                    ?>  
                    ><?= $value2; ?></li>
        <?php
                }
                echo '</ul></div>';
            }
        }
    ?>
    

    

    
    <div class="form-group col-md-12">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<script type="text/javascript">
 function checkAll(name = null) {
 	//alert(name);
    if($('#'+name).prop("checked")) {
        $('.'+name).prop("checked", true);
    } else {
        $('.'+name).prop("checked", false);
    }                
}
function checkSub(name = null){
	//alert(name);

        
            if($('.'+name).length == $('.'+name+":checked").length) {
                $('#'+name).prop("checked", true);
            }else {
                $('#'+name).prop("checked", false);            
            }
        

 }

</script>