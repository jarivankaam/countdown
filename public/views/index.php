<?php
// Read the target date from the file
$filename = 'target_date.txt';
$targetDate = '';

if (file_exists($filename)) {
    $targetDate = trim(file_get_contents($filename));
} else {
    echo "Error: Date file not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'requires/head.php'; ?>
<?php require_once 'parts/header.php'; ?>
<body>
    <div class="container flex align-items-center justify-content-center full-height">
        <div id="countdown">
          <p>Next session in:</p>
            <span id="days"></span> Days
            <span id="hours"></span> Hours
            <span id="minutes"></span> Minutes and
            <span id="seconds"></span> Seconds
        </div>
    </div>

    <script>
        // Set the target date from PHP
        const targetDate = new Date("<?php echo htmlspecialchars($targetDate); ?>");

        // Function to start and update the countdown timer
        function startCountdown() {
            const daysElement = document.getElementById('days');
            const hoursElement = document.getElementById('hours');
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate.getTime() - now;

                if (distance <= 0) {
                    document.getElementById('countdown').innerHTML = 'Countdown Finished!';
                    clearInterval(intervalId);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                daysElement.innerText = String(days);
                hoursElement.innerText = String(hours);
                minutesElement.innerText = String(minutes);
                secondsElement.innerText = String(seconds);
            }

            const intervalId = setInterval(updateCountdown, 1000);
        }

        // Start the countdown when the page loads
        document.addEventListener('DOMContentLoaded', startCountdown);
    </script>
</body>
</html>
