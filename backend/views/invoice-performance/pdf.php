<?php 

$output = '';
$output .= "<table class='table table-striped table-bordered' id='myTable'>
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
                </thead>";
                    

                if(count($list) == 0):
                    echo "No data available";
                else:
                    
$output .= "<tbody>
                <tr>
                    <td>".$list[0]['item_code']."</td>
                    <td>".$list[0]['item_name']."</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>";

                $item_name = "";
                $sum = 0;
                foreach($list as $key => $value): 
                    
                    if($item_name == ''){
                        $item_name = $value['item_name'];
                    }
                    if($item_name != $value['item_name']){

$output .= "<tr>
                            
                <td></td>
                <td></td>
                <td></td>
                <td>".$item_name."</td>
                <td>".number_format($sum,2)."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>".$value['item_code']."</td>
                <td>".$value['item_name']."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>";
      
            $sum = 0;
            $item_name = $value['item_name'];
            }
            $sum += $value['amount'];

$output .= "<tr>
                <td>".$value['customer_name']."</td>
                <td>".$value['invoice_no']."</td>
                <td>".$value['month']."</td>
                <td>".$value['quantity']."</td>
                <td>".$value['amount']."</td>
                <td>".$value['average_cost']."</td>
                <td>".$value['job_no']."</td>
                <td>".$value['sales_person']."</td>
                <td>".$value['customer_card_id']."</td>
            </tr>";

            endforeach;

$output .= "<tr>
                <td></td>
                <td></td>
                <td></td>
                <td>".$item_name."</td>
                <td>".number_format($sum,2)."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>";

        endif;

$output .= "</table>";
$mpdf->WriteHTML($output);
$date = date("F j, Y");  
$mpdf->Output($date.' Customer Performance Report.pdf', 'D');
exit;

