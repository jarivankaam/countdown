// Function to fetch the target date from the server
async function fetchTargetDate(): Promise<Date | null> {
  try {
    const response = await fetch("/save_date.php", {
      method: "GET",
    });
    const result = await response.json();
    if (result.status === "success") {
      const hiddenInputElement = document.getElementById(
        "hidden-target-date"
      ) as HTMLInputElement;
      hiddenInputElement.value = result.date;
      return new Date(result.date);
    } else {
      console.error("Error fetching date:", result.message);
      return null;
    }
  } catch (error) {
    console.error("Error fetching date:", error);
    return null;
  }
}

// Function to save the target date to the server
async function saveTargetDate(targetDate: string): Promise<void> {
  try {
    const response = await fetch("/save_date.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ targetDate }).toString(),
    });
    const result = await response.json();
    if (result.status === "success") {
      console.log("Date saved successfully:", targetDate);
    } else {
      console.error("Error saving date:", result.message);
    }
  } catch (error) {
    console.error("Error saving date:", error);
  }
}

// Function to start and update the countdown timer
function startCountdown(targetDate: Date): void {
  const daysElement = document.getElementById("days");
  const hoursElement = document.getElementById("hours");
  const minutesElement = document.getElementById("minutes");
  const secondsElement = document.getElementById("seconds");

  function updateCountdown(): void {
    const now = new Date().getTime();
    const distance = targetDate.getTime() - now;

    if (distance <= 0) {
      document.getElementById("countdown")!.innerHTML = "Countdown Finished!";
      clearInterval(intervalId);
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    if (daysElement) daysElement.innerText = String(days);
    if (hoursElement) hoursElement.innerText = String(hours);
    if (minutesElement) minutesElement.innerText = String(minutes);
    if (secondsElement) secondsElement.innerText = String(seconds);
  }

  const intervalId = setInterval(updateCountdown, 1000);
}

// Initialization when the DOM content is loaded
document.addEventListener("DOMContentLoaded", async () => {
  const hiddenInputElement = document.getElementById(
    "hidden-target-date"
  ) as HTMLInputElement;
  const targetDateElement = document.getElementById(
    "target-date"
  ) as HTMLInputElement;

  // Fetch the target date from the server
  const targetDate = await fetchTargetDate();
  if (targetDate) {
    startCountdown(targetDate);
    if (targetDateElement) {
      targetDateElement.value = targetDate.toISOString().slice(0, 16);
    }
  }

  // Admin-specific logic for setting the date
  const dateForm = document.getElementById("date-form");
  if (dateForm) {
    dateForm.addEventListener("submit", async (event) => {
      event.preventDefault();

      const targetDateInput = targetDateElement.value;
      const targetDateISO = new Date(targetDateInput).toISOString();
      hiddenInputElement.value = targetDateISO;

      await saveTargetDate(targetDateISO);
      const confirmationMessage = document.getElementById(
        "confirmation-message"
      );
      if (confirmationMessage) {
        confirmationMessage.innerText = "Target date saved successfully!";
      }
    });
  }
});
