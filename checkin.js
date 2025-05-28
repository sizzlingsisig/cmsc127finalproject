document.addEventListener("DOMContentLoaded", function () {
  const checkinBtn = document.getElementById("checkin-btn");

  if (checkinBtn) {
    checkinBtn.addEventListener("click", function () {
      const memberName = document.getElementById("member-search").value.trim();

      if (!memberName) {
        alert("Please enter a member name.");
        return;
      }

      fetch("checkin.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ member_name: memberName })
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            alert(data.message);
            document.getElementById("member-search").value = ""; // Clear input

            // ✅ Reload the page after a short delay (optional: 300ms)
            setTimeout(() => {
              window.location.reload();
            }, 300);
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(err => {
          console.error("Request failed", err);
          alert("Something went wrong.");
        });
    });
  }
});
