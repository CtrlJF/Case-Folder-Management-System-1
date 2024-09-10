function handleFileSelect(event) {
    var userId = event.target.getAttribute('data-user-kasabutan');
    var file = event.target.files[0]; // Assuming only one file is selected

    // Perform actions with userId and file
    console.log('User ID:', userId);
    console.log('File:', file);
    
    // Example: Upload file using AJAX
    var formData = new FormData();
    formData.append('file', file);
    formData.append('userId', userId);

    // Example AJAX request to handle file upload
    $.ajax({
        url: '../user/server/update/kasabutan_update.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Handle success
            alert(response.message);
            console.log('File uploaded successfully:', response);
            // Reload the page after a short delay (optional)
            setTimeout(function() {
                window.location.reload(); // Reload the current page
            }, 500); // Reload after 1 second (1000 milliseconds)
        },
        error: function(xhr, status, error) {
            // Handle error
            alert('Error uploading file');
            console.error('Error uploading file:', error);
            setTimeout(function() {
                window.location.reload(); // Reload the current page
            }, 500); // Reload after 1 second (1000 milliseconds)
        }
    });
}
