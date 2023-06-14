function decreaseValue(value) {
    el = document.getElementById(value)
    if (el.value > 1) {
        let decrementedValue = el.value
        decrementedValue--
        handleStockUpdate(value, decrementedValue, function (result) {
            if (result) {
                el.value--;
            } else {
                alert("error in updating stock")
            }
        })
    }
}
function increaseValue(value) {
    el = document.getElementById(value)
    let incrementedValue = el.value
    incrementedValue++
    handleStockUpdate(value, incrementedValue, function (result) {
        if (result) {
            el.value++;
        } else {
            alert("error in updating stock")
        }
    })
}

function handleStockUpdate(ids, value, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/pharmacist/manageStocks/updateStock.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                 if (response == 'notBranch'){
                    alert("You cant delete stock from other branches!")
                    callback(false)
                }else if (response == "true") {
                    callback(true)
                } else if (response.includes("rollBackQty")) {
                    let qty = response.split("rollBackQty")[1]
                    document.getElementById(ids).value = qty;
                    callback(false)
                }
                else {
                    callback(false)
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

    var data = "ids=" + encodeURIComponent(ids) + "&qty=" + encodeURIComponent(value);
    xhr.send(data);
}

function handleDelete(ids) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/pharmacist/manageStocks/deleteStock.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Request completed successfully
                var response = xhr.responseText;
                if (response == "true") {
                    // Delete the element with the provided sid
                    var element = document.getElementById(ids);
                    if (element) {
                        element.remove();
                    } else {
                        alert('Error deleting a stock')
                    }
                } else if (response == 'notBranch'){
                    alert("You cant delete stock from other branches!")
                }
                 else {
                    alert("Deletion failed")
                }
                // console.log(response)
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

    var data = "ids=" + encodeURIComponent(ids);
    xhr.send(data);
}