
<?php 

$output = '';

    if(isset($list_all)):

        $output .=  "<div>
                        <div style='text-align: center;'>
                            <h3>Customer Report</h3>
                        </div>
                        <div>";
                            if(count($list_all) > 0):
                                $total_amount = 0;
                                $total_expenses = 0;
                                $total_avg = 0;


                                foreach ($list_all as $key => $value) {
                                    $total_amount += $value['amount'];
                                    $total_expenses += $value['expenses'];
                                    $total_avg += $value['average_cost'];
                                }
                                $total_profit = $total_amount-$total_avg;
                                $share = number_format((($total_profit/$total_expenses)*100)*100,2);
                            
                $output .=  "<div>
                                <table border>
                                    <tr>
                                        <td><strong>Customer Name:</strong></td>
                                        <td>".$list_all[0]['customer_name']."</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Customer Code:</strong></td>
                                        <td>".$list_all[0]['customer_card_id']."</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Expenses:</strong></td>
                                        <td>$".number_format($total_expenses,2)."</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Profits:</strong></td>
                                        <td>";if($total_profit > 0 ){
                                            $output .=  "$".number_format($total_profit,4);
                                        }else{ 
                                            $output .=  "$0";
                                        }
                    $output .= "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Share Cost(%):</strong></td>
                                        <td>";if($share > 0 ){
                                                $output .=  $share."%";
                                            }else{ 
                                                $output .=  "0%";
                                            }
                    $output .= "</td>
                                    </tr>
                                </table>
                                
                            </div>
                            <div style='margin-top: 50px;'>
                                <strong>Month From: <u>".date_format(date_create($_POST['year_from'].'-'.$_POST['month_from']),"F")."</u> to <u>".date_format(date_create($_POST['year_to'].'-'.$_POST['month_to']),"F")."</u></strong>
                            </div>

                            <div style='margin-top: 10px;'>
                                <table width='100%' style='border:0; border-collapse:separate; border-spacing:0 5px;'>
                                    <thead>
                                        <tr >
                                            <th align='left'  style='border-bottom: 1px solid; border-collapse:separate; border-spacing:5px 5px;'>Month</th>
                                            <th align='left' style='border-bottom: 1px solid; border-collapse:separate; border-spacing:5px 5px;'>Total Sales</th>
                                            <th align='left' style='border-bottom: 1px solid; border-collapse:separate; border-spacing:5px 5px;'>Total Costs</th>
                                            <th align='left' style='border-bottom: 1px solid; border-collapse:separate; border-spacing:5px 5px;'>Total Profits</th>
                                            <th align='left' style='border-bottom: 1px solid; border-collapse:separate; border-spacing:5px 5px;'>%</th>
                                        </tr>

                                    </thead>

                                    <tbody>";

                                    $profits = 0;
                                    $grand_total_amount = 0;
                                    $grand_expenses = 0;
                                    $grand_profits = 0;
                                    $grand_avg = 0;
                                    foreach ($list_all as $key => $value):

                             $output .= "<tr>
                                            <td>".date_format(date_create($value['year'].'-'.$value['month']),"M")."</td>
                                        
                                            <td>$".number_format($value['amount'],2)."</td>
                                        
                                            <td>$".number_format($value['average_cost'],4)."</td>";
                                            $profits = $value['amount']-$value['average_cost']; 
                            $output .= " <td>";
                                                   if($profits > 0 ){ 
                                                            $output .= "$".number_format($profits,4); 
                                                        }else{ 
                                                            $output .=  "$0";
                                                        }
                                                        
                            $output .= "</td>
                                        
                                            <td>";
                                                    if((($profits/$value['expenses'])*100)*100 > 0){
                                                                $output .= number_format((($profits/$value['expenses'])*100)*100,2)."%";
                                                            }else{
                                                                $output .=  "$0";
                                                            }  
                                $output .= "</td>
                                        </tr>";

                                        $grand_total_amount += $value['amount'];
                                        $grand_expenses += $value['expenses'];
                                        $grand_profits += $profits;
                                        $grand_avg += $value['average_cost'];
                                    endforeach;

                              $output .= "<tr>
                                            <td style='border-top: 1px solid; border-collapse:separate; border-spacing:5px 5px;'><strong>Summary</strong></td>
                                        
                                            <td style='border-top: 1px solid; border-collapse:separate; border-spacing:5px 5px;'><strong>$".number_format($grand_total_amount,2)."</strong></td>
                                        
                                            <td style='border-top: 1px solid; border-collapse:separate; border-spacing:5px 5px;'><strong>$".number_format($grand_avg,4)."</strong></td>
                                        
                                            <td style='border-top: 1px solid; border-collapse:separate; border-spacing:5px 5px;'><strong>";
                                            if($grand_profits > 0){ 
                                                $output .=  "$".number_format($grand_profits,4); 
                                            }else{ 
                                                $output .=  "$0"; 
                                            }
                               $output .= " </strong></td>
                                        
                                            <td style='border-top: 1px solid; border-collapse:separate; border-spacing:5px 5px;'><strong>";
                                            if((($grand_profits/$grand_expenses)*100)*100 > 0){ 
                                                $output .=  number_format((($grand_profits/$grand_expenses)*100)*100,2)."%"; 
                                            }else{ 
                                                $output .=  "$0"; 
                                            }
                               $output .= " </strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>";

                            else:
                                echo 'No Data Available';
                            endif;


            $output .= "</div>
                    </div>";

                    endif;

$mpdf->WriteHTML($output);
$date = date("F j, Y");  
$mpdf->Output($date.' Customer Report.pdf', 'D');
exit;

