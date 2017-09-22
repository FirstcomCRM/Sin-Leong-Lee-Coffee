<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoicePerformanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Performances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-performance-index">
<?php $form = ActiveForm::begin(['id' => 'invoice-performance']); ?>

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
                            <th>Name</th>
                            <th>ID#</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Avg. Cost</th>
                            <th>Job No.</th>
                            <th>Sales person</th>
                            <th>Customer Card Id</th>
                        </tr>
                    </thead>
                    <?php

                        if(count($list) == 0):
                            echo "No data available";
                        else:
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $list[0]['item_code']; ?></td>
                            <td><?= $list[0]['item_name'];  ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                        $item_name = "";
                        $sum = 0;
                        foreach($list as $key => $value):

                            if($item_name == ''){
                                $item_name = $value['item_name'];
                            }
                            if($item_name != $value['item_name']){
                        ?>
                        <tr>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?= $item_name; ?></td>
                            <td><?= '$'.number_format($sum,2); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?= $value['item_code']; ?></td>
                            <td><?= $value['item_name']; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                        $sum = 0;
                        $item_name = $value['item_name'];
                        }
                        $sum += $value['amount'];
                    ?>
                        <tr>
                            <td><?= $value['customer_name']; ?></td>
                            <td><?= $value['invoice_no']; ?></td>
                            <td><?= $value['month']; ?></td>
                            <td><?= $value['quantity']; ?></td>
                            <td><?= '$'.$value['amount']; ?></td>
                            <td><?= '$'.$value['average_cost']; ?></td>
                            <td><?= $value['job_no']; ?></td>
                            <td><?= $value['sales_person']; ?></td>
                            <td><?= $value['customer_card_id']; ?></td>
                        </tr>
                    <?php
                        endforeach;
                    ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?= $item_name; ?></td>
                            <td><?= '$'.number_format($sum,2); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <?php
                        endif;
                    ?>
                </table>
            </div>
        </div>
    </div>


<?php ActiveForm::end(); ?>
</div>
