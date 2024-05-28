 // Add event listener to the form for sorting
 document.getElementById('sort-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    sortProducts(); // Call JavaScript function to sort products
  });