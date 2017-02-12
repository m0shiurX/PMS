<?php include 'includes/header.php'; ?>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Hello World
			</div>
			<div class="panel-body">
				<canvas id="myChart">
					
				</canvas>
			</div>
		</div>	
	</div>

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Hello World
			</div>
			<div class="panel-body">
			<canvas id="myChart2">
				
			</canvas>		
			</div>
		</div>	
	</div>	
	


<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	  type: 'bar',
	  data: {
	    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
	    datasets: [{
	      label: 'First',
	      data: [12, 19, 3, 17, 6, 3, 7],
	      backgroundColor: "rgba(153,255,51,0.6)"
	    }, {
	      label: 'Second',
	      data: [2, 29, 5, 5, 2, 3, 10],
	      backgroundColor: "rgba(255,153,0,0.6)"
	    }]
	  }
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url: "chart.php",
			method: "GET",
			dataType: 'JSON',
			success: function(data) {
				//console.log(data);
				var raw = [];
				var qty = [];

				for(var i in data) {
					raw.push(data[i].raw_id);
					qty.push(data[i].raw_quantity);
				}
				console.log(raw);
				console.log(qty);
				var chartdata = {
					labels: raw,
					datasets : [
						{
							label: 'Raw Materials Stock',
							backgroundColor: 'rgba(255,153,0,0.6)',
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
							data: qty
						}
					]
				};

				var ctx = $('#myChart2');

				var barGraph = new Chart(ctx, {
					type: 'bar',
					data: chartdata
					// options: {
					//     scales: {
					//         yAxes: [{
					//             ticks: {
					//                 // Create scientific notation labels
					//                 callback: function(value, index, values) {
					//                     return value.toExponential();
					//                 }
					//             }
					//         }]
					//     }
					// }
				});
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
</script>