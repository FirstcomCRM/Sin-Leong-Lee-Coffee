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

$excel_expense = Expenses::find()->where(['between','month',$date_from,$date_to])->sum('total');
$rebate_list = AccountList::find()->where(['transaction_type'=>'Rebate'])->all();
$all = InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->sum('amount');
$all_cost =  InvoicePerformance::find()->andFilterwhere(['between', 'date', $date_from,$date_to])->all();

foreach ($all_cost as $key => $value) {
  $cost = $value->quantity * $value->average_cost;
  $sum_cost += $cost;
}
$aProfit = $all-$sum_cost;

$sales_codes = ['4-1110','4-1120','4-1130','4-1140'];//Item code for sales coffee, sales tea, sales mug and spoon and sales others
$cost_codes = ['5-1110','5-1120','5-1130','5-1140'];//Item code for cost of goods coffee, cost of goods tea, cost of goods mug and spoon and cost of goods others

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
$expense_per = ($gProfit/($aProfit))*100;
$used_expense = $gProfit/$aProfit;
//echo $expense_per;

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
  .td-left{
    width: 40%;
    border: none;
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

<p class="cust-name"><h1 style="text-align: center;font-weight:bold;">Sin Leong Lee Coffee Pte Ltd</h1></p>
<p class="cust-name"><h2 style="text-align: center;font-weight:bold;"><?php echo $searchModel->customer_name ?></h2> </p>
<p><strong><?php echo date('m/d/Y') ?></strong> </p>
<p><strong><?php echo date("h:i:sa") ?></strong> </p>

<!---Regarding the formula in the excel file
total sales amount = amount * quantity
total cost amount = avg cost * quanty
--->
<hr style="border-color:black;height:1px">
<!--Income Table-->
<table class="table income-table" >
<tr>
  <td colspan = "2">Income</td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title">Sales</span></td>
</tr>
<tr>
  <td class="td-left" > <span class="sub-name"></span>4-1110 Sales Coffee</td>
  <td>
    <?php echo '$'.number_format($sales_income[0],2); ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">4-1120  Sales Tea</td>
  <td>
      <?php echo '$'.number_format($sales_income[1],2); ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">4-1130 Sales Mug & Spoons</td>
  <td>
    <?php echo '$'.number_format($sales_income[2],2); ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">4-1140 Sales Others</td>
  <td>
      <?php echo '$'.number_format($sales_income[3],2); ?>
  </td>
</tr>

<tr><!--Rebate and Discount row-->
  <td class="td-left"><span class="sub-title">Rebates & Discount</td>
</tr>
<?php foreach ($rebate_list as $value): ?>
  <?php
    $rebate_reports = RebateReport::find()->where(['account'=>$value->account])
                    ->andWhere(['customer'=>$searchModel->customer_name])
                    ->one();
   ?>

     <tr>
       <td class="td-left"><span class="sub-name"><?php echo $value->account.' '.$value->account_details ?></span></td>
       <td>
         <?php
            $rebate_sum =  RebateReport::find()->where(['account'=>$value->account])
                      ->andWhere(['customer'=>$searchModel->customer_name])
                      ->andWhere(['between','date',$date_from,$date_to])
                      ->sum('amount');
            //echo '($'.abs(number_format($rebate_sum,2)).')';
            $rebate_sum = abs($rebate_sum);
            echo '($'.number_format($rebate_sum,2). ')'
          ?>
       </td>
     </tr>

<?php endforeach; ?>

<tr>
  <td class="td-left"><span class="sub-title total">Total Rebate and Discount</td>
  <td>
    <span class="total">
      <?php
         $rebate_sum =  RebateReport::find() ->where(['customer'=>$searchModel->customer_name])
                   ->andWhere(['between','date',$date_from,$date_to])
                   ->sum('amount');
         //echo '($'.abs(number_format($rebate_sum,2)).')';
         $rebate_sum = abs($rebate_sum);
         echo '($'.number_format($rebate_sum,2). ')'
       ?>
    </span>
  </td>
</tr>

<tr>
  <td class="td-left"><span class="sub-title total">Total Income</td>
  <td>
    <span class="total">
      <?php echo '$'.number_format(array_sum($sales_income),2); ?>
    </span>
  </td>
</tr>

</table>

<br>
<!--Cost of Sales Table-->
<table class="table cost-table">
<tr>
  <td colspan = "2">Cost of Sales</td>
</tr>
<tr>
  <td colspan = "2"><span class="sub-title">Cost of Sales</span></td>
</tr>
<tr>
  <td class="td-left"> <span class="sub-name"></span>5-1110 Cost of Goods Coffee</td>
  <td>
    <?php echo '$'.number_format($cost_goods[0],2) ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">5-1120 Cost of Goods Tea</td>
  <td>
    <?php echo '$'.number_format($cost_goods[1],2) ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">5-1130 Cost of Goods Mug</td>
  <td>
    <?php echo '$'.number_format($cost_goods[2],2) ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-name">5-1140 Cost of Goods Others</td>
  <td>
    <?php echo '$'.number_format($cost_goods[3],2) ?>
  </td>
</tr>
<tr>
  <td class="td-left"><span class="sub-title total">Total Cost of Sales</td>
  <td>
    <span class="total">
        <?php echo '$'.number_format(array_sum($cost_goods),2); ?>
      </span>
  </td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table gross-table">

<tr>
  <td class="td-left"><span class="total">Customer Gross Profit</span></td><!--Customer gross  profit for months in between--->
  <td><span class="total"><?php echo '$'.number_format($gProfit,2); ?>  </span></td>
</tr>

<br>
<!--All Gross Profit Table-->
<table class="table gross-table">
  <tr>
    <td class="td-left"><span class="total">Total Income</span></td>
    <td><span class="total">
        <?php $income = array_sum($sales_income)- $rebate_sum;
          echo '$'.number_format($income,2);
        ?>
    </span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="total">Cost of Sales</span></td>
    <td><span class="total"><?php echo '$'.number_format(array_sum($cost_goods),2 ); ?></span></td>
  </tr>
<tr>
  <td class="td-left"><span class="total">Total Income.</span></td><!--all gross  profit for months in between--->
  <td>
    <span class="total">
      <?php
      echo '$'.number_format($gProfit,2);
      ?>
    </span>
  </td>
</tr>


<br>
<!--Cost of Expenses Table-->
<table class="table expense-table">
  <tr>
    <td colspan = "2">Expense</td>
  </tr>
  <tr>
    <td class="td-left" colspan="2"><span class="sub-title">Expense</span></td>
  </tr>
  <tr>
    <td class="td-left"><span class="sub-name">Share Expenses Amount</span></td>
    <td>
      <?php
        $expense = $gProfit/$aProfit;
        $shared_expense = $excel_expense * $expense;
        echo '$'.number_format($shared_expense,2);
      ?>
    </td>
  </tr>

  <tr><!--start of administrative cost---->
    <td class="td-left"><span class="sub-title">Administrative Costs</span></td>
    <td><?php echo '($'.number_format(array_sum($admin_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($admin_cost)*$used_expense,3) ?></td>
  </tr>


  <tr><!--start of fixed asset cost---->
      <td class="td-left"><span class="sub-title">Fixed Asset Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($fixed_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($fixed_cost)*$used_expense,3) ?></td>
  </tr><!--end of fixed asset cost---->

  <tr><!--start of Utilities Costs---->
      <td class="td-left"><span class="sub-title">Utilities Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($util_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($util_cost)*$used_expense,3)  ?></td>
  </tr><!--end of Utilities Costs---->

  <tr><!--start of Employment Costs---->
      <td class="td-left"><span class="sub-title">Employment Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($employ_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($employ_cost)*$used_expense,3) ?></td>
  </tr><!--end of Employment Costs---->

  <tr><!--start of Marketing Costs---->
      <td class="td-left"><span class="sub-title">Marketing Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($market_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($market_cost)*$used_expense,3) ?></td>
  </tr><!--end of Marketing Costs---->

  <tr><!--start of Customer Expenses---->
      <td class="td-left"><span class="sub-title">Customer Expenses</span></td>
        <td><?php echo '($'.number_format(array_sum($custom_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($custom_cost)*$used_expense,3) ?></td>
  </tr><!--end of Customer Expenses---->

  <tr><!--start of Factory Maintenance Costs---->
      <td class="td-left"><span class="sub-title">Factory Maintenance Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($fact_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($fact_cost)*$used_expense,3) ?></td>
  </tr><!--end of Factory Maintenance Costs---->


  <tr> <!--start of Motor Vehicle Costs---->
      <td class="td-left"><span class="sub-title">Motor Vehicle Costs</span></td>
      <td><?php echo '($'.number_format(array_sum($motor_cost),2).')&emsp;&emsp;'.  '$'.number_format(array_sum($motor_cost)*$used_expense,3) ?></td>
  </tr><!--end of Motor Vehicle Costs---->


<tr>
  <td class="td-left"><span class="sub-title total">Total Shared Expenses</span></td>
  <td>
    <span class="total">
      <?php
        $excel_expense = number_format($excel_expense,2);
        echo '$'.$excel_expense;
       ?>
      <?php// edr echo  '$'.number_format($total_expenses,2)?>
    </span>
  </td>
</tr>
</table>


<br>
<!--Cost of Gross Profit Table-->
<table class="table net-table">
<tr>
  <td class="td-left"><span class="total">Net Profit</span></td>
  <td>
    <span class="total">
      <?php echo '$'.number_format($gProfit,2) ?>
    </span>
  </td>
</tr>

<tr>
  <td class="td-left"><span class="total">Shared Expense Percentage</span></td>
  <td>
    <span class="total">
      <?php
        echo number_format($expense_per,3).'%';
      ?>
    </span>
  </td>
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
  <td class="td-left"><span class="total">Total All Gross Profit</span></td><!--all gross  profit for months in between--->
  <td>
    <span class="total">
      <?php
  //    $allProfit = $gProfit - $aProfit;
      echo '$'.number_format($aProfit,2);
      ?>
    </span>
  </td>
</tr>
