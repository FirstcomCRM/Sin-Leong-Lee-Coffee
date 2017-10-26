//onload document.ready
$(function() {
    var type = $('#asset-type').val();
    if (type == 1) {
      $('.boiler-sum').show();
    }else{
      $('.boiler-sum').hide();
    }

  //  var testdata = new Date('2017-1-1')
//    var date = moment(testdata); //Get the current date
//    var con_date = date.format("YYYY-MM-DD"); //2014-07-10
//    console.log(con_date);

  $("#asset-type").change(function () {
        var end = this.value;
        //var firstDropVal = $('#pick').val();
        console.log(end);
        if (end == 1) {

          $('.boiler-sum').show();
        }else{

            $('.boiler-sum').hide();
        }
    });

  $('#cost-id').change(function(){
    getDepn();
    getNbv();
  });

  $('#acc-depn-id').change(function(){
    getNbv();
  });

  $('#years').change(function(){
    $("#date_to").empty();
    $("#date_from").empty();
    var year_base = parseInt($('#years').val());
  //  var year_add = parseInt(year_base)+5;
    var year_add = parseInt(year_base)+5;
    var option = '';
    var dates = ''
    var testdate = '';
    var con_date = '';
  //  console.log(year_base);
  //  console.log(year_add);
    for (var y = year_base; y <= year_add; y++) {
//      console.log(y);
      for (var m = 1; m <= 12; m++) {
        var dates = y+'-'+m+'-'+01;
        var testdate = new Date(dates);
        var moment_date = moment(testdate);
        var con_date = moment_date.format("YYYY-MM-DD")
      //  console.log(con_date);
      //  option += '<option value="'+ dates + '">' + dates + '</option>';
       option += '<option value="'+ con_date + '">' + con_date + '</option>';
      }
    }
    /*var qty = 5;
    var option = '';
    for (var i=1;i <= qty;i++){
      option += '<option value="'+ i + '">' + i + '</option>';
    }*/
    $('#date_to').append(option);
    $('#date_from').append(option);

  });

  $('#date_to').change(function(){
      createLine();

  });

});


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


function createLine(){
  var date_to = $('#date_to').val();
  var date_from = $('#date_from').val();
  var date_from_a = $('#date_from').val();
  var cost = $('#cost-id').val();
  var purchase_cost = $('#purchase-cost').val();
  var zero = 0;

  var year_result =  moment(date_to).diff(moment(date_from),'years',true);
  $('#total_dep_year').val(parseInt(year_result));

  var dep_amount = purchase_cost - cost;
  $('#total_dep_amount').val(dep_amount);

  var result = moment(date_to).diff(moment(date_from),'months',true);
//  console.log(result);
  var test_to = moment(date_to);
   $('#depreciate >tbody >tr').remove();
  // var depreciate_value = (dep_amount/year_result)*0.08;
  var depreciate_value = (dep_amount/year_result);
   depreciate_value = parseFloat(depreciate_value).toFixed(2);
// var test_res = moment().add(6,'months');
//var test_res = moment(date_to).add(2, 'month').format("YYYY-MM-DD");
  $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+date_from_a+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+zero+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+dep_amount+ '">'+'</td></tr>');

for (var i = 0; i < result; i++) {
//  var test_res = moment(date_from).add(1, 'month').format("YYYY-MM-DD");
//    console.log(test_res);
//    console.log(date_from);
   purchase_cost = purchase_cost - depreciate_value;
   purchase_cost = parseFloat(purchase_cost).toFixed(2);
   date_from = moment(date_from).add(1, 'month').format("YYYY-MM-DD");
   $('#depreciate > tbody').append('<tr><td><input type="text" class="form-control" name="year_list[]" value="'+date_from+ '">'+'</td><td><input type="text" class="form-control" name="dep_value[]" value="'+depreciate_value+ '">'+'</td><td><input type="text" class="form-control" name="dep_expense[]" value="'+purchase_cost+ '">'+'</td></tr>');


}
  var balance = purchase_cost;
    $('#balance').val(parseFloat(balance).toFixed(2));
//   console.log(test_res);
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
