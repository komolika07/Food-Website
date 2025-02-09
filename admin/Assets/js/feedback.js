function confirmDeleteFeedback(id) {
    console.log("ID to delete:", id); // Debug the ID being passed

    if (confirm("Are you sure you want to delete this feedback?")) {
        fetch(`../includes/deleteFeedback.php?id=${id}`, {
            method: "GET",
        })
            .then((response) => response.text())
            .then((data) => {
                console.log("Response from server:", data); // Log the server response
                if (data.includes("success")) {
                    alert("Feedback deleted successfully.");
                    // Optionally, remove the row from the table
                    const row = document.querySelector(`button[onclick='confirmDeleteFeedback(${id})']`).closest("tr");
                    row.remove();
                } else {
                    alert("Failed to delete Feedback: " + data);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });
    } else {
        console.log("Deletion canceled.");
    }
}