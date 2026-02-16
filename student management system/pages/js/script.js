function random(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Traffic Chart
new Chart(document.getElementById('trafficChart'), {
    data: {
        labels: ['Jan 01','Jan 02','Jan 03','Jan 04','Jan 05','Jan 06','Jan 07'],
        datasets: [
            {
                type: 'bar',
                label: 'Website Blog',
                data: Array.from({length: 7}, () => random(200, 800)),
                backgroundColor: '#0d6efd'
            },
            {
                type: 'line',
                label: 'Social Media',
                data: Array.from({length: 7}, () => random(150, 600)),
                borderColor: '#20c997',
                tension: 0.4,
                pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Income Chart
new Chart(document.getElementById('incomeChart'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [75, 25],
            backgroundColor: ['#0d6efd', '#e9ecef'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '75%',
        plugins: {
            legend: { display: false },
            tooltip: { enabled: false }
        }
    }
});