<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Report';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="invoice-performance-index">
<?php $form = ActiveForm::begin(['id' => 'customer']); ?>
    
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <strong class="col-md-2">Customer Name</strong>
                <select name="customer" class="col-md-4 btn btn-default" required>
                <?php
                $customer = array();
                foreach ($list as $key => $value) {
                    $customer[] = $value['customer_name'];
                }
                ?>
                    <option value="">--Select Customer Name--</option>
                    <?php
                        foreach (array_unique($customer) as $key => $value) {
                    ?>
                    <option <?php if (isset($_POST['customer']) && $_POST['customer'] == $value) echo "selected";?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php
                        }
                    ?>

                </select>
            </div>
            <div class="col-md-12" style="margin-top: 5px;">
                <strong class="col-md-2">Date From</strong>
                <select name="month_from" class="col-md-2 btn btn-default" required>
                    <option value="">--Select Month--</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="1") echo "selected";?> value='1'>January</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="2") echo "selected";?> value='2'>February</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="3") echo "selected";?> value='3'>March</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="4") echo "selected";?> value='4'>April</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="5") echo "selected";?> value='5'>May</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="6") echo "selected";?> value='6'>June</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="7") echo "selected";?> value='7'>July</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="8") echo "selected";?> value='8'>August</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="9") echo "selected";?> value='9'>September</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="10") echo "selected";?> value='10'>October</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="11") echo "selected";?> value='11'>November</option>
                    <option <?php if (isset($_POST['month_from']) && $_POST['month_from'] =="12") echo "selected";?> value='12'>December</option>
                </select>

                <select name="year_from" class="col-md-1 btn btn-default" required>
                    <option value="">Year</option>
                        <?php 

                           for($i = date('Y') ; $i >= 1950; $i--){
                            //echo "<option value = $i>$i</option>";
                            ?>
                              <option <?php if (isset($_POST['year_from']) && $_POST['year_from'] == $i) echo "selected";?> value='<?php echo $i;?>'><?php echo $i;?></option>
                              <?php
                           }
                        ?>
                </select>
            </div>

            <div class="col-md-12" style="margin-top: 5px;">
                <strong class="col-md-2">Date To</strong>
                <select name="month_to" class="col-md-2 btn btn-default" required>
                    <option value="">--Select Month--</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="1") echo "selected";?> value='1'>January</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="2") echo "selected";?> value='2'>February</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="3") echo "selected";?> value='3'>March</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="4") echo "selected";?> value='4'>April</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="5") echo "selected";?> value='5'>May</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="6") echo "selected";?> value='6'>June</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="7") echo "selected";?> value='7'>July</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="8") echo "selected";?> value='8'>August</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="9") echo "selected";?> value='9'>September</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="10") echo "selected";?> value='10'>October</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="11") echo "selected";?> value='11'>November</option>
                    <option <?php if (isset($_POST['month_to']) && $_POST['month_to'] =="12") echo "selected";?> value='12'>December</option>
                </select>

                <select name="year_to" class="col-md-1 btn btn-default" required>
                    <option value="">Year</option>
                        <?php 

                           for($i = date('Y') ; $i >= 1950; $i--){
                            //echo "<option value = $i>$i</option>";
                            ?>
                              <option <?php if (isset($_POST['year_to']) && $_POST['year_to'] == $i) echo "selected";?> value='<?php echo $i;?>'><?php echo $i;?></option>
                              <?php
                           }
                        ?>
                </select>
            </div>
            <div class="col-md-12" style="margin-top: 5px;">
                
                    <input type="submit" name="search" class="btn btn-primary" value="Search">
                    <?php
                        if(isset($list_all)):
                    ?>
                    <input type="submit" name="pdf" class="btn btn-success" value="PDF">
                    <?php
                        endif;
                    ?>
            </div>
        </div>

    </div>

    <?php 
    if(isset($list_all)):
    ?>
    <div class="box box-info">
        <div class="box-header with-border" style="text-align: center;">
            <h3 class="box-title" ><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?php
            if(count($list_all) > 0):
                
            ?>
            <?php
                $total_amount = 0;
                $total_expenses = 0;
                $total_avg = 0;


                foreach ($list_all as $key => $value) {
                    $total_amount += $value['amount'];
                    $total_expenses += $value['expenses'];
                    $total_avg += $value['average_cost'];
                }
                $total_profit = $total_amount-$total_avg;
                $share = number_format(($total_profit/$total_expenses)*100,2);
            ?>
            <div>
                <table >
                    <tr>
                        <td><strong>Customer Name:</strong></td>
                        <td align="center"><?php echo $list_all[0]['customer_name']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Customer Code:</strong></td>
                        <td><?php echo $list_all[0]['customer_card_id']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Expenses:</strong></td>
                        <td><?php echo '$'.number_format($total_expenses,2); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Profits:</strong></td>
                        <td><?php if($total_profit > 0 ){echo '$'.number_format($total_profit,2);}else{ echo 0;}  ?></td>
                    </tr>
                    <tr>
                        <td><strong>Share Cost(%):</strong></td>
                        <td><?php if($share > 0 ){echo $share.'%' ;}else{ echo 0;} ?></td>
                    </tr>
                </table>
            </div>
            <div style="margin-top: 50px;">
                <strong>Month From: <u><?php echo date_format(date_create($_POST['year_from'].'-'.$_POST['month_from']),"F"); ?></u> to <u><?php echo date_format(date_create($_POST['year_to'].'-'.$_POST['month_to']),"F"); ?></u></strong>
            </div>

            <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Sales</th>
                            <th>Total Costs</th>
                            <th>Total Profits</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $profits = 0;
                    $grand_total_amount = 0;
                    $grand_expenses = 0;
                    $grand_profits = 0;
                    $grand_avg = 0;
                    foreach ($list_all as $key => $value):
                    ?>
                        <tr>
                            <td><?php echo date_format(date_create($value['year'].'-'.$value['month']),"M"); ?></td>
                        
                            <td><?php echo '$'.number_format($value['amount'],2); ?></td>
                        
                            <td><?php echo '$'.number_format($value['average_cost'],2); ?></td>
                            <?php $profits = $value['amount']-$value['average_cost']; ?>
                            <td><?php   if($profits > 0 ){ 
                                            echo '$'.number_format($profits,2); 
                                        }else{ 
                                            echo 0;
                                        } ?>
                                        
                            </td>
                        
                            <td><?php   if(($profits/$value['amount'])*100 > 0){
                                                echo number_format(($profits/$value['amount'])*100,2).'%';
                                            }else{
                                                echo 0;
                                            }  ?>
                            </td>
                        </tr>

                    <?php    

                        $grand_total_amount += $value['amount'];
                        $grand_expenses += $value['expenses'];
                        $grand_avg += $value['average_cost'];
                        $grand_profits += $profits;
                    endforeach;
                    ?>
                        <tr>
                            <td>Summary</td>
                        
                            <td><?php echo '$'.number_format($grand_total_amount,2); ?></td>
                        
                            <td><?php echo '$'.number_format($grand_avg,2); ?></td>
                        
                            <td><?php if($grand_profits > 0){ echo '$'.number_format($grand_profits,2); }else{ echo 0; }  ?></td>
                        
                            <td><?php if(($grand_profits/$grand_expenses)*100 > 0){ echo  number_format(($grand_profits/$grand_total_amount)*100,2).'%'; }else{ echo 0; }  ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
            else:
                echo 'No Data Available';
            endif;

            ?>
        </div>
    </div>
    <?php
    endif;
    ?>
<?php ActiveForm::end(); ?>
</div>
