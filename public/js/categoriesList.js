function handleDelete(cid) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/pharmacist/manageCategories/deleteCategory.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Request completed successfully
                var response = xhr.responseText;
                if (response == "true") {
                    // Delete the element with the provided cid
                    var element = document.getElementById(cid);
                    if (element) {
                        element.remove();
                    } else {
                        alert('Error deleting a supplier')
                    }
                } else {
                    // alert("Deletion failed")
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

    var data = "cid=" + encodeURIComponent(cid);
    xhr.send(data);
}
