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
                // Request completed successfully
                var response = xhr.responseText;
                if (response == "true") {
                    callback(true)
                } else {
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

