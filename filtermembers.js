function toggleDropdown(button) {
  const dropdown = button.nextElementSibling;
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

function filterMembers(type) {
  const url = new URL(window.location.href);
  if (type === 'all') {
    url.searchParams.delete('filter');
  } else {
    url.searchParams.set('filter', type);
  }
  window.location.href = url.toString();
}

// Optional: close dropdown on outside click
document.addEventListener("click", function (event) {
  const dropdowns = document.querySelectorAll(".dropdown-menu");
  dropdowns.forEach(dropdown => {
    if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
      dropdown.style.display = "none";
    }
  });
});
