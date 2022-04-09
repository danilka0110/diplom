<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class='center-block' style='width: 400px; height: 200px'id='correct_and_incorrect_answers_graph'><canvas id='myChart1' width='2' height='1'></canvas></div>

<?php

$array_with_labels = [12, 12, 3, 5, 2, 3];
$labels = json_encode($array_with_data);

$array_with_data = [12, 12, 3, 5, 2, 3];
$data = json_encode($array_with_data);

?>

  <script>
  var data = <?php echo $data ?>;
  var data = <?php echo $data ?>;
  const ctx = document.getElementById('myChart1').getContext('2d');
  const myChart = new Chart(ctx, {
  type: 'bar',
  data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
        label: '# of Votes',
        data: data,
        backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
        }]
  },
  options: {
        scales: {
        y: {
                beginAtZero: true
        }
        }
  }
  });
  </script>

