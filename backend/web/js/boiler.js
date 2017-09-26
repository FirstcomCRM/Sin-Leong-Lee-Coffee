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
//  year_to = parseInt(year_to);
//  year_from = parseInt(year_from);
  console.log('break');
  console.log('Year From '+year_from);
  console.log('Year To '+year_to);
  console.log('Purchase '+purchase);
  console.log('Cost '+cost);

  //console.log(year_to);
  //console.log(year_from);
  if (year_from != '' && year_to != '' && purchase != '' & cost != '') {
      $('#depreciate >tbody >tr').remove();
      year_to = parseInt(year_to);
      year_from = parseInt(year_from);
      var dep_amount = purchase - cost;
      var depreciate_value = dep_amount/(year_to - year_from);
      depreciate_value = parseFloat(depreciate_value).toFixed(2);
  //    console.log(jQuery.type(year_from));
  //    console.log(jQuery.type(year_to));
      for (var i = year_from; i <= year_to; i++) {
      //  $('#depreciate > tbody').append('<tr><td>your data1</td><td>your data2</td><td>your data3</td></tr>');
        purchase = purchase -depreciate_value;
        purchase = parseFloat(purchase).toFixed(2);
        $('#depreciate > tbody').append('<tr><td>'+i+'</td><td>'+depreciate_value+'</td><td>'+purchase+'</td></tr>');

        //console.log(i);
        console.log(i);

        //console.log(purchase);
      }

  }
}
