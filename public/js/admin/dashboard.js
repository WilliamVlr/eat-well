const ctx = document.getElementById('myChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: window.labels,
        datasets: [{
            label: 'Sales',
            data: window.chartData,
            backgroundColor: 'rgba(125, 99, 132, 0.5)',
            borderColor: 'rgba(175, 192, 192, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                onClick: null
            }
        }
    }
});
