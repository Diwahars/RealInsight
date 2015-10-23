google.load('visualization', '1.1', {packages: ['line']});
google.setOnLoadCallback(drawChart);

function drawChart() {
  var company = $('.division').attr('id');
  var content;
  $.ajax({
    url: '/php/companyNew.php?t=1&c='+company,
    dataType: 'json',
    async: false,
    success: function(data){;
      content = data;
    }
  });
  var data = new google.visualization.DataTable(content);

  var options = {
    chart: {
      title: 'Company Ratings for last 10 months In Terms Of Ratings',
      subtitle: 'averaged over all users registered from this company'
    },
    width: 900,
    height: 500,
    backgroundColor: 'cyan'
  };

  var chart = new google.charts.Line(document.getElementById('chart_div'));

  chart.draw(data, options);
}

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
  var company = $('.division').attr('id');
  var companyName = $('.division .page-header').attr('id');
  var content;
  $.ajax({
    url: '/php/companyNew.php?t=2&c='+company,
    dataType: 'json',
    async: false,
    success: function(data){
      content = data;
    }
  });
  var data = new google.visualization.DataTable(content);
  var options = {
    title: 'Gender distribution in '+companyName
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}

$(document).ready(function(){
  $('#logout').click(function(){
    window.location = '/php/error.php';
  });
});