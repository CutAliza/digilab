<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        .dashboard {
            display: flex;
            width: 100%;
        }

        /* Sidebar */
        .sidebar {
            background-color: #2c3e50;
            color: #ecf0f1;
            width: 250px;
            padding: 20px;
            height: 100vh;
            box-sizing: border-box;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        header {
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat {
            background-color: #3498db;
            color: white;
            padding: 20px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
            border-radius: 8px;
        }

        .stat h3 {
            font-size: 2.5rem;
            margin: 0;
        }

        .stat p {
            margin: 5px 0 0;
        }

        .chart {
            margin-bottom: 20px;
        }

        .recent-activities ul {
            list-style: none;
            padding: 0;
        }

        .recent-activities ul li {
            background-color: #ecf0f1;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Transactions</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <h1>Welcome, Admin!</h1>
                <p>Here is an overview of the system performance today.</p>
            </header>

            <!-- Statistics -->
            <section class="stats">
                <div class="stat">
                    <h3>500</h3>
                    <p>Active Users</p>
                </div>
                <div class="stat">
                    <h3>120</h3>
                    <p>Transactions Today</p>
                </div>
                <div class="stat">
                    <h3>5</h3>
                    <p>New Articles</p>
                </div>
            </section>

            <!-- Chart (Placeholder) -->
            <section class="chart">
                <h2>System Performance</h2>
                <canvas id="performanceChart"></canvas>
            </section>

            <!-- Recent Activities -->
            <section class="recent-activities">
                <h2>Recent Activities</h2>
                <ul>
                    <li>New user registered: Rahma Maelani</li>
                    <li>Transaction #12345 completed</li>
                    <li>Article "How to Use MongoDB" published</li>
                </ul>
            </section>
        </main>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart Implementation
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Visitors',
                        data: [120, 200, 150, 80, 70, 110, 300],
                        borderColor: 'rgba(52, 152, 219, 1)',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
            <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
