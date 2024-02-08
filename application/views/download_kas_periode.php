<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<body>
    <center><canvas id="myChart" style="width:100%;"></canvas></center>

    <br>
    <br>
    <br>
    <?= $tabel ?>
    <script>
        const xValues = <?= $tipe ?>;

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: <?= $dataset ?>},
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script>