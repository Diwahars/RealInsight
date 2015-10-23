google.load('visualization', '1.1', {packages: ['line']});
google.setOnLoadCallback(drawChart);

function drawChart() {

  // var data = new google.visualization.DataTable();
  // data.addColumn('number', 'Month');
  // data.addColumn('number', 'Overall Satisfaction Level');
  // data.addColumn('number', 'Average Salary of City');
  var cityID = $('#myCarousel').attr('data-city');
  var content;
  $.ajax({
    url: '/php/company.php?t=1&c='+cityID,
    dataType: 'json',
    async: false,
    success: function(data){
      content = data;
    }
  });
  var data = new google.visualization.DataTable(content);

  var options = {
    chart: {
      title: 'City Details In Terms Of User Prosperity',
      subtitle: 'averaged over all users registered from this city'
    },
    width: 900,
    height: 500,
    backgroundColor: 'cyan'
  };

  var chart = new google.charts.Line(document.getElementById('curve_chart'));

  chart.draw(data, options);

  $.ajax({
    url: '/php/company.php?t=2&c='+cityID,
    success: function(data){
      $('#ranking').html(data);
    }
  });
}