<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceQuantitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Quantity';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-quantity-index">
<?php $form = ActiveForm::begin(['id' => 'invoice-quantity']); ?>
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <div class="box-body">
            <select name="month" class="col-md-2 btn btn-default" id="month" required>
                <option value="">--Select Month--</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="January") echo "selected";?> value='January'>January</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="February") echo "selected";?> value='February'>February</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="March") echo "selected";?> value='March'>March</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="April") echo "selected";?> value='April'>April</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="May") echo "selected";?> value='May'>May</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="June") echo "selected";?> value='June'>June</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="July") echo "selected";?> value='July'>July</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="August") echo "selected";?> value='August'>August</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="September") echo "selected";?> value='September'>September</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="October") echo "selected";?> value='October'>October</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="November") echo "selected";?> value='November'>November</option>
                <option <?php if (isset($_POST['month']) && $_POST['month'] =="December") echo "selected";?> value='December'>December</option>
            </select>
            <select name="year" class="col-md-1 btn btn-default" id="year" required>
                <option value="">Year</option>
                <?php

                   for($i = date('Y') ; $i >= 1950; $i--){
                    //echo "<option value = $i>$i</option>";
                    ?>
                      <option <?php if (isset($_POST['year']) && $_POST['year'] == $i) echo "selected";?> value='<?php echo $i;?>'><?php echo $i;?></option>
                      <?php
                   }
                ?>
            </select>
            &nbsp;
            <input type="submit" name="search" value="Search" class="btn btn-primary">
            <input type="submit" name="excel" value="Excel" class="btn btn-success">
            <input type="submit" name="pdf" value="PDF" class="btn btn-success">
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Date</th>
                            <th>Item Code</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $number = 1;
                            if (count($list) == 0 ):
                                echo 'No Data Available';
                                else:
                                foreach($list as $value):
                        ?>
                        <tr>
                            <th scope="row"><?= $number; ?></th>
                            <td><?= $value['item_name']; ?></td>
                            <td><?= $value['month']; ?></td>
                            <td><?= $value['item_code']; ?></td>
                            <td><?= $value['total_quantity']; ?></td>
                        </tr>
                        <?php
                            $number++;
                            endforeach;
                            endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
