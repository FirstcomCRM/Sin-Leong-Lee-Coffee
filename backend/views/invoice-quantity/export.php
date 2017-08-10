
<?php  

ob_end_clean();


$output = '';
 
$output .= '<h1>'.$list[0]['month'].'</h1>';



$output .= "<table class='table table-bordered' id='myTable'>
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
            
                 
                

header('Content-Type: application/xls');
$date = date("F j, Y");  
header('Content-Disposition: attachment; filename="'.$date.'" Customer Quantity Report.xls');
echo $output;
  exit();

