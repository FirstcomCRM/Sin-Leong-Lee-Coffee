//onload document.ready
$(function() {

  $('#depn-rate').change(function(){
      createLine();
  });


});

function createLine(){

  var purchase_cost = $('#purchase-cost').val();
  var purchase_cost_a = $('#purchase-cost').val();
  var depn_rate = $('#depn-rate').val();
  var int_depn_rate = parseInt(depn_rate);
  var purchase_date = $('#purchase-date').val();
  var purchase_date_a = $('#purchase-date').val();
  var zero = 0;
  $('#total_dep_amount').val(parseFloat(purchase_cost).toFixed(2));

  var end_purchase_date =  moment(purchase_date).add(int_depn_rate,'years').format('YYYY-MM-DD');
  var result = moment(end_purchase_date).diff(moment(purchase_date),'months',true);

  var depreciate_value = (parseInt(purchase_cost)/(int_depn_rate*12)).toFixed(2);

  $('#depreciate >tbody >tr').remove();
  $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" readonly name="year_list[]" value="'+purchase_date+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+zero+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase_cost+ '">'+'</td></tr>');

  for (var i = 0; i < result; i++) {
     purchase_cost = purchase_cost - depreciate_value;
     purchase_cost = parseFloat(purchase_cost).toFixed(2);
     purchase_date = moment(purchase_date).add(1, 'month').format("YYYY-MM-DD");
     $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" readonly name="year_list[]" value="'+purchase_date+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+depreciate_value+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase_cost+ '">'+'</td></tr>');

  }
    var balance = purchase_cost;
      $('#balance').val(parseFloat(balance).toFixed(2));

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

        if (i==year_from) {
        $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+i+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+zero+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase+ '">'+'</td></tr>');

        }else{
          purchase = purchase -depreciate_value;
          purchase = parseFloat(purchase).toFixed(2);
          $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+i+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+-depreciate_value+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase+ '">'+'</td></tr>');

        }

      }
      var balance = purchase;

      $('#total_dep_year').val(year_amount);
      $('#total_dep_amount').val(parseFloat(dep_amount).toFixed(2));
      $('#balance').val(parseFloat(balance).toFixed(2));
  }

}
