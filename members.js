document.querySelectorAll('.sort-btn').forEach(button => {
  button.addEventListener('click', () => {
    const table = button.closest('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const colIndex = parseInt(button.dataset.column);

    // Track sorting order
    let ascending = button.dataset.ascending === 'true';
    ascending = !ascending; // Toggle

    // Save order state to button dataset, reset others
    document.querySelectorAll('.sort-btn').forEach(btn => {
      btn.dataset.ascending = 'false';
      btn.textContent = btn.textContent.replace(/ ↑| ↓/, '');
    });
    button.dataset.ascending = ascending.toString();

    // Sort rows
    rows.sort((a, b) => {
      let aText = a.children[colIndex].textContent.trim();
      let bText = b.children[colIndex].textContent.trim();

      // For dates, parse into Date objects
      if (colIndex === 2 || colIndex === 3) {
        aText = new Date(aText);
        bText = new Date(bText);
      } else {
        aText = aText.toLowerCase();
        bText = bText.toLowerCase();
      }

      if (aText > bText) return ascending ? 1 : -1;
      if (aText < bText) return ascending ? -1 : 1;
      return 0;
    });

    // Rebuild tbody
    rows.forEach(row => tbody.appendChild(row));

    // Add arrow to header button
    button.textContent += ascending ? ' ↑' : ' ↓';
  });
});
