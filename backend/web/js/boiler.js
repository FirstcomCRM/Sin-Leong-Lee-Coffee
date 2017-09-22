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
