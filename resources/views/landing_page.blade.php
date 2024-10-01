<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f2f5;
        }
        .coming-soon-container {
            text-align: center;
        }
        h1 {
            font-size: 4rem;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        .countdown {
            font-size: 2rem;
            font-weight: 500;
            margin-top: 20px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <h1>Coming Soon</h1>
        <p>Our website is under construction. Stay tuned for something amazing!</p>
        <div class="countdown">Launching in: <span id="countdown-timer">00d 00h 00m 00s</span></div>
    </div>

    <script>
        // Set the launch date
        const launchDate = new Date("Nov 01, 2024 00:00:00").getTime();

        const countdownTimer = setInterval(function() {
            const now = new Date().getTime();
            const timeLeft = launchDate - now;

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById("countdown-timer").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            if (timeLeft < 0) {
                clearInterval(countdownTimer);
                document.getElementById("countdown-timer").innerHTML = "Launched!";
            }
        }, 1000);
    </script>
</body>
</html>
