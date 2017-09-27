function getDepn(){
  var cost = $('#cost-id').val();
  var depn =  cost/3;
  $('#depn-id').val(parseFloat(depn).toFixed(2));
}

function getNbv(){
  var cost = $('#cost-id').val();
  var acc = $('#acc-depn-id').val();
  var depn = cost/3;

  var nbv = cost - acc - depn;
  $('#nbv-id').val(parseFloat(nbv).toFixed(2));
}

function getYear() {

  var year_from = $('#year_from').val();
  var year_to = $('#year_to').val();
  var purchase = $('#purchase-cost').val();
  var cost = $('#cost-id').val();
  $('#purchase-cost-a').val(purchase);
  var zero = 0;

  if (year_from != '' && year_to != '' && purchase != '' & cost != '') {
      $('#depreciate >tbody >tr').remove();
      year_to = parseInt(year_to);
      year_from = parseInt(year_from);
      var dep_amount = purchase - cost;
      var year_amount =year_to - year_from;
      var depreciate_value = dep_amount/(year_to - year_from);
      depreciate_value = parseFloat(depreciate_value).toFixed(2);

      for (var i = year_from; i <= year_to; i++) {
      //  $('#depreciate > tbody').append('<tr><td>your data1</td><td>your data2</td><td>your data3</td></tr>');

        if (i==year_from) {
        //    $('#depreciate > tbody').append('<tr><td><input type="text" name="test[]" value="'+i+ '">'+i+'</td><td><input type="text" name="dep_value[]" value="'+-depreciate_value+ '">'+'</td><td>'+purchase+'</td></tr>');
        $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+i+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+zero+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase+ '">'+'</td></tr>');

        }else{
          purchase = purchase -depreciate_value;
          purchase = parseFloat(purchase).toFixed(2);
          $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+i+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+-depreciate_value+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase+ '">'+'</td></tr>');

        }
      //  $('#depreciate > tbody').append('<tr><td>'+i+'</td><td>'+depreciate_value+'</td><td>'+purchase+'</td></tr>');


      }
      var balance = purchase;

      $('#total_dep_year').val(year_amount);
      $('#total_dep_amount').val(parseFloat(dep_amount).toFixed(2));
      $('#balance').val(parseFloat(balance).toFixed(2));
    

  }
}
