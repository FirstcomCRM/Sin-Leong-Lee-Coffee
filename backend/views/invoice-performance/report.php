<?php

use yii\helpers\ArrayHelper;
use backend\models\InvoicePerformance;
use backend\models\Expenses;
use backend\models\ExpensesReport;
use backend\models\AssetType;
use backend\models\AccountList;
use backend\models\RebateReport;

$total_expenses = 0;
$total_cost = 0;
$sum_cost = 0;
$ind_total = 0;
$ind_name  = 0;
$ind_summation =[];

$excel_expense = Expenses::find()->where(['between','month',$date_from,$date_to])->sum('total');
$rebate_list = AccountList::find()->where(['transaction_type'=>'Rebate'])->all();
$all = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->sum('amount');
$all_cost =  InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->all();
$all_rebates = RebateReport::find()->andFilterWhere(['between', 'date', $date_from,$date_to])->sum('amount');

foreach ($all_cost as $key => $value) {
  $cost = $value->quantity * $value->average_cost;
  $sum_cost += $cost;
}
$aProfit = $all-($sum_cost+abs($all_rebates));

print_r($aProfit);
$sales_codes = ['4-1110','4-1120','4-1130','4-1140'];//Item code for sales coffee, sales tea, sales mug and spoon and sales others
//$cost_codes = ['5-1110','5-1120','5-1130','5-1140'];//Item code for cost of goods coffee, cost of goods tea, cost of goods mug and spoon and cost of goods others
$cost_codes = ['5-1110','5-1120','5-1130','5-1140','5-1150','5-1160','5-1170'];
//Sum of sales income based on the sales code. [0]=sales coffee, [1]=sales tea, [2]=sales mug and spoon, [3]= sales others
$sales_income = [];
foreach ($sales_codes as  $value) {
  $sales_income[] =  InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                    ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                    ->andFilterWhere(['item_list.income'=>$value ])
                    ->sum('amount');
}

//Sum of cost of goods based on the cost_code.  [0]=cost of goods coffee, [1]=cost of goods tea, [2]=cost of goods mug and spoon, [3]= cost of goods others
$cost_goods = [];
$avg_cost = 0;
$cost_total = 0;
foreach ($cost_codes as $value) {
      $costs  = InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                   ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                   ->andFilterWhere(['item_list.exp_cos'=>$value ])
                   ->asArray()
                   ->all();
      foreach ($costs as $key => $value) {
         $avg_cost = $value['quantity'] * $value['average_cost'];
         $cost_total += $avg_cost;
      }
      $cost_goods[] =$cost_total;
      $avg_cost = 0;
      $cost_total = 0;
}



//get the incomve vs cost of goods
$gProfit = array_sum($sales_income) - array_sum($cost_goods);

//get the shared expense percentage value
$expense_per = ($gProfit/($aProfit-abs($all_rebates)))*100;
$used_expense = $gProfit/($aProfit-abs($all_rebates));
//echo $expense_per;

//Invidiual expenses area
$ind = InvoicePerformance::find()->select(['item_name'])->distinct()
       ->andFilterWhere(['between', 'date', $date_from,$date_to])
      ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
      ->andFilterWhere(['amount'=>0])
      ->asArray()
      ->orderBy(['item_name'=>SORT_ASC])
      ->all();


//Sum of expense type, administrative cost
$admin_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Administrative Costs'])->asArray()->all();
foreach ($data as $value) {
  $admin_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}


//Sum of expense type, Fixed asset cost_total
$fixed_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Fixed Asset Costs'])->asArray()->all();
foreach ($data as $value) {
  $fixed_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}

//Sum of expense type, Utilities Costs
$util_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Utilities Costs'])->asArray()->all();
foreach ($data as $value) {
  $util_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}


//Sum of expense type, employement cost_total
$employ_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Employment Costs'])->asArray()->all();
foreach ($data as $value) {
  $employ_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}

//Sum of expense type, Marketing Costs
$market_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Marketing Costs'])->asArray()->all();
foreach ($data as $value) {
  $market_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}

//Sum of expense type, Customer Expenses
$custom_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Customer Expenses'])->asArray()->all();
foreach ($data as $value) {
  $custom_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}

//sum of expene type, Factory maintenance cost
$fact_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Factory Maintenance Costs'])->asArray()->all();
foreach ($data as $value) {
  $fact_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}


//sum of expense type, motor vehicle cost_total
$motor_cost = [];
$data = AccountList::find()->where(['transaction_group'=>'Motor Vehicle Costs'])->asArray()->all();
foreach ($data as $value) {
  $motor_cost[] = ExpensesReport::find()->where(['id_code'=>$value['account']])
                ->andWhere(['between','date_uploaded',$date_from,$date_to])
                ->sum('debit');
}


$month_from = $searchModel->month_from;
$year_from = $searchModel->year_from;
$month_to = $searchModel->month_to;
$year_to = $searchModel->year_to;
$merge_from = $month_from.' '.$year_from;
$merge_to = $month_to.' '.$year_to;

//$cost_goods = [];
 ?>

<style>

  td{
    border: none;
  }

  .cust_name{
    font-weight: bold;
  }
  .sub-title{
    padding-left: 2em;
  }
  .sub-title-a{
    font-weight: bold;
  }
  .td-left{
    width: 40%;
    border: none;
  }
  .td-remain{
    width: 20%;
  }
  .sub-name{
    padding-left: 4em;
  }
  .total{
    font-weight: bold;
    font-size: 20px;
  }
</style>

<div class="container">

<p class="cust-name"><h1 style="text-align: center;font-weight:bold;"><?php echo $searchModel->customer_name ?></h1></p>

<?php if ($merge_from == $merge_to): ?>
  <p class="cust-name"><h3 style="text-align: center;font-weight:bold;"><?php echo $month_from.' '.$year_from ?></h3></p>
<?php else: ?>
  <p class="cust-name"><h3 style="text-align: center;font-weight:bold;"><?php echo $merge_from.' - '.$merge_to ?></h3></p>
<?php endif; ?>

<!---Regarding the formula in the excel file
total sales amount = amount * quantity
total cost amount = avg cost * quanty
--->

<hr style="border-color:black;height:1px">
<!--Income Table-->
<table class="table income-table" >
<tr>
  <td colspan = "2"><h4>Income</h4></td>
  <td> <h4>% by income</h4></td>
  <td><h4>% by GP</h4></td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title sub-title-a">Sales</span></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"> <span class="sub-title"></span>Sales Coffee</td>
  <td>
    <?php echo $sales_income[0] == 0 ? '-':number_format($sales_income[0],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Sales Tea</td>
  <td>
    <?php echo $sales_income[1] == 0 ? '-':number_format($sales_income[1],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Sales Mug & Spoons</td>
  <td>
    <?php echo $sales_income[2] == 0 ? '-':number_format($sales_income[2],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Sales Others</td>
  <td>
      <?php echo $sales_income[3] == 0 ? '-':number_format($sales_income[3],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td> <br> </td>
  <td></td>
  <td></td>
  <td></td>
</tr>
<tr><!--Rebate and Discount row-->
  <td class="td-left" colspan = 4><span class="sub-title sub-title-a">Rebates & Discount</td>
</tr>
<?php foreach ($rebate_list as $value): ?>
     <tr>
       <td class="td-left"><span class="sub-title"><?php echo $value->account_details ?></span></td>
       <td>
         <?php
            $rebate_sum =  RebateReport::find()->where(['account'=>$value->account])
                      ->andWhere(['customer'=>$searchModel->customer_name])
                      ->andWhere(['between','date',$date_from,$date_to])
                      ->sum('amount');
            //echo '($'.abs(number_format($rebate_sum,2)).')';
            $rebate_sum = abs($rebate_sum);
            echo $rebate_sum == 0 ? '-':'('.number_format($rebate_sum,2). ')';
          ?>
       </td>
       <td></td>
       <td></td>
     </tr>
<?php endforeach; ?>

<?php
  $rebate_sum =  RebateReport::find() ->where(['customer'=>$searchModel->customer_name])
             ->andWhere(['between','date',$date_from,$date_to])
             ->sum('amount');
     //echo '($'.abs(number_format($rebate_sum,2)).')';
      $rebate_sum = abs($rebate_sum);
?>


<tr>
  <td class="td-left"><span class="sub-title"><strong>Total Income</strong></td>
  <td class="td-remain">
    <span><strong>
      <?php
        $total_income = array_sum($sales_income) - $rebate_sum;
        echo number_format($total_income,2);
      ?>
    </strong></span>
  </td>
  <td class="td-remain">100%</td>
  <td class="td-remain"></td>
</tr>

<!---get the % by income in total income and cost of Sales--->
<?php $cost_perc = (array_sum($cost_goods)/$total_income )*100 ?>

</table>

<br>
<!--Cost of Sales Table-->
<table class="table cost-table">
<tr>
  <td colspan = "2"><h4>Cost of Sales</h4></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title"><strong>Cost of Sales</strong></span></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"> <span class="sub-title"></span>Cost of Goods Coffee</td>
  <td>
    <?php echo $cost_goods[0] == 0 ? '-':number_format($cost_goods[0],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Cost of Goods Tea</td>
  <td>
    <?php echo $cost_goods[1] == 0 ? '-':number_format($cost_goods[1],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Cost of Goods Mug</td>
  <td>
    <?php echo $cost_goods[2] == 0 ? '-':number_format($cost_goods[2],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title">Cost of Goods Others</td>
  <td>
    <?php echo $cost_goods[3] == 0 ? '-':number_format($cost_goods[3],2)?>
  </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title"><strong>Total Cost of Sales</strong></td>
  <td class="td-remain">
    <span><strong>
        <?php echo number_format(array_sum($cost_goods),2); ?>
    </strong> </span>
  </td>
  <td class="td-remain"><?php echo round($cost_perc).'%' ?></td>
  <td class="td-remain"></td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table gross-table">

<tr>
  <td class="td-left"><span class="total">Gross Profit</span></td><!--Customer gross  profit for months in between--->
  <td class="td-remain"><span class="total">
    <?php
      $customer_gross = $gProfit- $rebate_sum;
      echo number_format($customer_gross,2); ?>
  </span></td>
  <td class="td-remain"><?php echo 100-round($cost_perc).'%' ?></td>
  <td class="td-remain">100%</td>
</tr>
</table>
<!--insert here individual expenses-->
<table class="table individual">
  <tr>
    <td colspan = "2"><h4>Individual Expenses</h4></td>
  </tr>
  <?php foreach ($ind as $key => $value): ?>
    <tr>
      <td class="td-left" ><span class="sub-title"><?php echo $value['item_name'] ?></span></td>
      <?php
      $ind_sub = InvoicePerformance::find()->select(['average_cost','quantity'])
              ->andFilterWhere(['between', 'date', $date_from,$date_to])
              ->andFilterWhere(['customer_name'=>$searchModel->customer_name])
              ->andFilterWhere(['amount'=>0])
              ->andFilterWhere(['item_name'=>$value['item_name']])
              ->asArray()
              ->orderBy(['item_name'=>SORT_ASC])
              ->all();
       ?>
       <?php foreach ($ind_sub as $key => $value_a): ?>
         <?php $ind_name = $value_a['average_cost']*$value_a['quantity'];
          $ind_total +=$ind_name;
       ?>
       <?php endforeach; ?>
       <?php $ind_summation[]=$ind_total ?>
        <td>
          <?php echo $ind_total == 0 ? '-':number_format($ind_total,2) ?>
        </td>
    </tr>
  <?php endforeach; ?>
  <tr>
    <td class="td-left"><span class="sub-title"><strong>Total Individual Expenses</strong></td>
    <td class="td-remain">
      <span><strong>
        <?php echo array_sum($ind_summation) == 0 ? '-':number_format(array_sum($ind_summation),2) ?>
      </strong></span>
    </td>
    <td class="td-remain">0.00</td>
    <td class="td-remain">0.00</td>
  </tr>

</table>

<br>
<!--Cost of Expenses Table-->
<table class="table expense-table">
  <tr>
    <td><strong>Shared Expenses (Gross Profit Ratio)</strong></td>
    <td><strong><?php  echo number_format($expense_per,3).'%';?></strong></td>
    <td></td>
    <td></td>
  </tr>

  <tr><!--start of administrative cost---->
    <td class="td-left"><span class="sub-title">Administrative Costs</span></td>
    <td><?php echo array_sum($admin_cost)== 0? '-':number_format(array_sum($admin_cost),2) ?></td>
    <td></td>
    <td></td>
  </tr>

  <tr><!--start of fixed asset cost---->
      <td class="td-left"><span class="sub-title">Fixed Asset Costs</span></td>
      <td><?php echo array_sum($fixed_cost)== 0? '-':number_format(array_sum($fixed_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of fixed asset cost---->

  <tr><!--start of Utilities Costs---->
      <td class="td-left"><span class="sub-title">Utilities Costs</span></td>
      <td><?php echo array_sum($util_cost)== 0? '-':number_format(array_sum($util_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Utilities Costs---->

  <tr><!--start of Employment Costs---->
      <td class="td-left"><span class="sub-title">Employment Costs</span></td>
      <td><?php echo array_sum($employ_cost)== 0? '-':number_format(array_sum($employ_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Employment Costs---->

  <tr><!--start of Marketing Costs---->
      <td class="td-left"><span class="sub-title">Marketing Costs</span></td>
      <td><?php echo array_sum($market_cost)== 0? '-':number_format(array_sum($market_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Marketing Costs---->

  <tr><!--start of Customer Expenses---->
      <td class="td-left"><span class="sub-title">Customer Expenses</span></td>
      <td><?php echo array_sum($custom_cost)== 0? '-':number_format(array_sum($custom_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Customer Expenses---->

  <tr><!--start of Factory Maintenance Costs---->
      <td class="td-left"><span class="sub-title">Factory Maintenance Costs</span></td>
      <td><?php echo array_sum($fact_cost)== 0? '-':number_format(array_sum($fact_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Factory Maintenance Costs---->

  <tr> <!--start of Motor Vehicle Costs---->
      <td class="td-left"><span class="sub-title">Motor Vehicle Costs</span></td>
      <td><?php echo array_sum($motor_cost)== 0? '-':number_format(array_sum($motor_cost),2) ?></td>
      <td></td>
      <td></td>
  </tr><!--end of Motor Vehicle Costs---->


<tr>
  <td class="td-left"><span class="sub-title"><strong>Total Shared Expenses</strong></span></td>
  <td class="td-remain">
    <span><strong>
      <?php
        $excel_expense = number_format($excel_expense,2);
        echo ''.$excel_expense;
       ?>
    </strong></span>
  </td>
  <td class="td-remain">0%</td>
  <td class="td-remain">0%</td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table net-table">
<tr>
  <td class="td-left"><span class="total">Net Profit</span></td>
  <td class="td-remain">
    <span class="total">
      <?php echo number_format($gProfit,2) ?>
    </span>
  </td>
  <td class="td-remain">0%</td>
  <td class="td-remain">0%</td>
</tr>
</table>

</div>


<hr>

<table class="table gross-table">
  <tr>
    <td class="td-left"><span class="total">Total All Sales Amount</span></td>
    <td><span class="total"><?php echo '$'.number_format($all,2) ?></span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="total">Total All Cost Amount</span></td>
    <td><span class="total"><?php echo '$'.number_format($sum_cost,2) ?></span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="total">Total All Rebates</span></td>
    <td><span class="total"><?php echo '$'.number_format(abs($all_rebates),2) ?></span></td>
  </tr>
<tr>
  <td class="td-left"><span class="total">Total All Gross Profit</span></td><!--all gross  profit for months in between--->
  <td>
    <span class="total">
      <?php
     $allProfit = $gProfit - ($aProfit);
      echo '$'.number_format($aProfit,2);
      ?>
    </span>
  </td>
</tr>
</table>

<hr>

<?php
$all_sales_income = [];
foreach ($sales_codes as  $value) {
  $all_sales_income[] =  InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                    ->andFilterWhere(['item_list.income'=>$value ])
                    ->sum('amount');
}


$all_cost_goods = [];
$all_avg_cost = 0;
$all_cost_total = 0;
foreach ($cost_codes as $value) {
      $all_costs  = InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
                   //->andFilterWhere(['customer_name'=>$searchModel->customer_name])
                   ->andFilterWhere(['item_list.exp_cos'=>$value ])
                   ->asArray()
                   ->all();
      foreach ($all_costs as $key => $value) {
        if ($value['average_cost']==0) {
           $all_avg_cost = $value['quantity'] * $value['sales_person'];
        }else{
           $all_avg_cost = $value['quantity'] * $value['average_cost'];
        }

         $all_cost_total += $all_avg_cost;
      }
      $all_cost_goods[] =$all_cost_total;
      $all_avg_cost = 0;
      $all_cost_total = 0;
}

 ?>


<table class="table">
  <tr>
    <td colspan="2">4-1000 SALES</td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>4-110 Sales Coffee</td>
    <td>  <?php echo $all_sales_income[0] == 0 ? '-':number_format($all_sales_income[0],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>4-1120 Sales Tea</td>
    <td>  <?php echo $all_sales_income[1] == 0 ? '-':number_format($all_sales_income[1],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>4-1130 Sales Mugs & spoon</td>
    <td>  <?php echo $all_sales_income[2] == 0 ? '-':number_format($all_sales_income[2],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>4-1140 Sales others</td>
      <td>  <?php echo $all_sales_income[3] == 0 ? '-':number_format($all_sales_income[3],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>Sales Total</td>
    <td> <span></span><?php echo number_format(array_sum($all_sales_income),2) ?></td>
  </tr>
  <tr>
    <td colspan="2">4-2000 Rebates & Discount</td>
  </tr>
  <?php foreach ($rebate_list as $value): ?>
       <tr>
         <td class="td-left"><span class="sub-title"><?php echo $value->account.' '.$value->account_details ?></span></td>
         <td>
           <?php
              $rebate_sum =  RebateReport::find()->where(['account'=>$value->account])
                      //  ->andWhere(['customer'=>$searchModel->customer_name])
                        ->andWhere(['between','date',$date_from,$date_to])
                        ->sum('amount');
              //echo '($'.abs(number_format($rebate_sum,2)).')';
              $rebate_sum = abs($rebate_sum);
              echo $rebate_sum == 0 ? '-':'('.number_format($rebate_sum,2). ')';
            ?>
         </td>
         <td></td>
         <td></td>
       </tr>
  <?php endforeach; ?>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>Rebates Totall</td>
    <?php $rebate_alls =RebateReport::find()->andWhere(['between','date',$date_from,$date_to])->sum('amount');  ?>
    <td><?php echo number_format($rebate_alls,2) ?></td>
  </tr>
    <td class="td-left"> <span class="sub-title"></span><strong>TOTAL INCOME</strong> </td>
    <td>
      <?php $total_inc = array_sum($all_sales_income) - abs($rebate_alls) ?>
      <?php echo number_format($total_inc,2); ?>
    </td>
  <tr>
    <td colspan="2">5-1000 Cost of Sales</td>
  </tr>
  <tr>
      <td class="td-left"> <span class="sub-title"></span>5-1110 Cost of Goods Coffee</td>
      <td><?php echo $all_cost_goods[0] == 0 ? '-':number_format($all_cost_goods[0],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1120 Cost of Goods tea</td>
      <td><?php echo $all_cost_goods[1] == 0 ? '-':number_format($all_cost_goods[1],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1130 Cost of Goods Mugs & Spoon</td>
      <td><?php echo $all_cost_goods[2] == 0 ? '-':number_format($all_cost_goods[2],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1140 Cost of Goods Others</td>
      <td><?php echo $all_cost_goods[3] == 0 ? '-':number_format($all_cost_goods[3],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1150 Cost of Goods Others</td>
      <td><?php echo $all_cost_goods[4] == 0 ? '-':number_format($all_cost_goods[3],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1160 Cost of Goods Others</td>
      <td><?php echo $all_cost_goods[5] == 0 ? '-':number_format($all_cost_goods[3],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>5-1170 Cost of Goods Others</td>
      <td><?php echo $all_cost_goods[6] == 0 ? '-':number_format($all_cost_goods[3],2)?></td>
  </tr>
  <tr>
    <td class="td-left"> <span class="sub-title"></span>Total Cost of Sales</td>
    <td> <?php echo number_format(array_sum($all_cost_goods),2) ?></td>
  </tr>
</table>


<br>
<hr>
<table class="table">
  <?php
  $all_costs  = InvoicePerformance::find()->joinWith(['codes'])->andFilterwhere(['between', 'date', $date_from,$date_to])
               //->andFilterWhere(['customer_name'=>$searchModel->customer_name])
               ->andFilterWhere(['item_list.exp_cos'=>'5-1110' ])
               ->asArray()
               ->all();

   ?>
  <?php foreach ($all_costs as $key => $value): ?>
    <tr>
      <td><?php echo $value['item_name'] ?> </td>
      <?php $data[] = $value['average_cost']*$value['sales_person'] ?>
      <td> <?php echo $value['average_cost']*$value['sales_person'] ?></td>
    </tr>
  <?php endforeach; ?>
  <tr>
    <td>Cost total</td>
    <td><?php echo array_sum($data) ?></td>
  </tr>
</table>
