<?php
// Assume some role-checking logic here
// For demonstration purposes, we'll simulate a delay and return a dummy role

sleep(20); // Simulate a delay (remove this line in a real scenario)

// Return a dummy role (replace this with your actual role-checking logic)
echo 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Role Example</title>
  <!-- Include jQuery (you can download it or use a CDN) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

  <h1>Check Role Example</h1>

  <div id="loading" style="display: none;">Loading...</div>

  <script>
    function checkUserRole() {
      // Show loading indicator
      $('#loading').show();

      // Simulate an AJAX request (replace with actual AJAX code)
      $.ajax({
        type: 'GET',
        url: 'check-role.php', // Replace with the actual server-side script
        success: function(response) {
          // Hide loading indicator
          $('#loading').hide();

          // Process the response (you can update the UI or perform other actions)
          console.log('User role:', response);
        },
        error: function() {
          // Handle errors (show an error message, etc.)
          $('#loading').hide();
          console.error('Error checking user role');
        }
      });
    }

    // Call the function when the page loads
    $(document).ready(function() {
      checkUserRole();
    });
  </script>

</body>
</html>