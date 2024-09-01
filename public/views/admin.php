<!DOCTYPE html>
<html lang="en">
<?php require_once 'requires/head.php'; ?>
<?php require_once 'parts/header.php'; ?>
<body>
    <h1>Set Countdown Target Date</h1>
    <form id="date-form">
        <label for="target-date">Target Date:</label>
        <input type="datetime-local" id="target-date" name="target-date" required>
        <input type="hidden" id="hidden-target-date" name="hidden-target-date"> <!-- Hidden input to store the date -->
        <button type="submit">Save Date</button>
    </form>

    <p id="confirmation-message"></p>

    <script>
        // Load the existing date from the hidden input (if it's already set)
        document.addEventListener('DOMContentLoaded', () => {
            const hiddenInputElement = document.getElementById('hidden-target-date');
            if (hiddenInputElement.value) {
                // Set the form's datetime-local input to match the hidden input value
                document.getElementById('target-date').value = new Date(hiddenInputElement.value).toISOString().slice(0, 16);
            } else {
                // Optionally, load from localStorage if you want to populate the form
                const savedDate = localStorage.getItem('target-date');
                if (savedDate) {
                    document.getElementById('target-date').value = new Date(savedDate).toISOString().slice(0, 16);
                    hiddenInputElement.value = savedDate; // Update the hidden input with the saved date
                }
            }
        });

        // Handle form submission
        document.getElementById('date-form').addEventListener('submit', (event) => {
            event.preventDefault();

            const targetDateInput = document.getElementById('target-date').value;
            const targetDate = new Date(targetDateInput).toISOString();

            // Update the hidden input field with the new date
            document.getElementById('hidden-target-date').value = targetDate;

            // Optionally save the date to localStorage as well
            localStorage.setItem('target-date', targetDate);

            // Show confirmation message
            document.getElementById('confirmation-message').innerText = "Target date saved successfully!";
        });
    </script>
</body>
<script>
  AOS.init();
</script>
</html>
