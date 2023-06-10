function handleDelete(pid) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/pharmacist/manageProducts/deleteProduct.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Request completed successfully
                var response = xhr.responseText;
                if (response == "true") {
                    // Delete the element with the provided pid
                    var element = document.getElementById(pid);
                    if (element) {
                        element.remove();
                    } else {
                        alert('Error deleting a patient')
                    }
                } else {
                    console.log("Deletion request failed.");
                    console.log(response)
                }
            } else {
                console.log("Error sending deletion request. Status code: " + xhr.status);
            }
        }
    };

    xhr.onerror = function () {
        // Request error occurred
        console.log("Error sending deletion request.");
        // You can add any additional error handling code here
    };

    var data = "pid=" + encodeURIComponent(pid);
    xhr.send(data);
}
