<?php 

$output = '';
 

$output .= "<h1>".$list[0]['month']."<h1>
            <table width='100%' id='myTable'>
            <thead>
              <tr>                  
                  <th>Item Name</th>
                  <th>Date</th>
                  <th>Item Code</th>
                  <th>Total Quantity</th>
              </tr>
            </thead>
            <tbody>";

            if (count($list) == 0 ):
                echo 'No Data Available';
                else:
                foreach($list as $value): 

$output .= "<tr>
                <td>".$value['item_name']."</td>
                <td>".$value['month']."</td>
                <td>".$value['item_code']."</td>
                <td>".$value['total_quantity']."</td>
            </tr>";
  
            endforeach;
            endif;

$output .= "</tbody>
      </table>";

$mpdf->WriteHTML($output);
$date = date("F j, Y");  
$mpdf->Output($date.' Customer Quantity Report.pdf', 'D');
exit;

