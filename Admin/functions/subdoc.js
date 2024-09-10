// Function to handle file selection
function FileHandle(event, url) {
    currentUserId = event.target.getAttribute('data-user-id');
    currentName = event.target.getAttribute('data-user-name');
    var file = event.target.files[0]; // Assuming only one file is selected

    if (currentUserId === null) {
        console.error('User ID not set.');
        return;
    }
    if (!file) {
        console.error('No file selected.');
        return;
    }

    console.log('User ID:', currentUserId);
    console.log('User Name:', currentName);
    console.log('File:', file);

    // Example: Upload file using AJAX
    var formData = new FormData();
    formData.append('file', file);
    formData.append('userId', currentUserId);
    formData.append('userName', currentName);

    // Example AJAX request to handle file upload
    $.ajax({
        url: url,
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
            }, 500); // Reload after 0.5 second (500 milliseconds)
        },
        error: function(xhr, status, error) {
            // Handle error
            alert('Error uploading file');
            console.error('Error uploading file:', error);
            setTimeout(function() {
                window.location.reload(); // Reload the current page
            }, 500); // Reload after 0.5 second (500 milliseconds)
        }
    });
};

function handleFileSelect(event) {
    FileHandle(event, '../Admin/server/create/gis_create.php');
}; 

function handleFileSelect1(event) {
    FileHandle(event, '../Admin/server/create/swdi_create.php');
};

function handleFileSelect2(event) {
    FileHandle(event, '../Admin/server/create/haf_create.php');
};

function handleFileSelect3(event) {
    FileHandle(event, '../Admin/server/create/scsr_create.php');
};

function handleFileSelect4(event) {
    FileHandle(event, '../Admin/server/create/car_create.php');
};

function handleFileSelect5(event) {
    FileHandle(event, '../Admin/server/create/aer_create.php');
};

function handleFileSelect6(event) {
    FileHandle(event, '../Admin/server/create/pn_create.php');
};

function handleFileSelect7(event) {
    FileHandle(event, '../Admin/server/create/psms_create.php');
};

function handleFileSelect8(event) {
    FileHandle(event, '../Admin/server/create/rl_create.php');
};

