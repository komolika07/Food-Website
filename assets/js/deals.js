document.addEventListener("DOMContentLoaded", function () {
    const timers = document.querySelectorAll(".deal-timer");

    function updateTimer() {
        timers.forEach(timer => {
            let expiryDate = new Date(timer.getAttribute("data-expiry")).getTime();
            let now = new Date().getTime();
            let difference = expiryDate - now;

            if (difference > 0) {
                let days = Math.floor(difference / (1000 * 60 * 60 * 24));
                let hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((difference % (1000 * 60)) / 1000);
                timer.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                timer.innerHTML = "Expired";
            }
        });
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});
