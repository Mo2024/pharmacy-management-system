function handleCart(pid, price) {

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/ajax/checkStock.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Request completed successfully
                let exists = false;
                var cart = JSON.parse(localStorage.getItem('cart')) || [];

                var response = parseInt(xhr.responseText);
                for (const item of cart) {
                    if (item.pid == pid) {
                        if (parseInt(item.qty) >= response) {
                            alert("exceeded available quantity")
                            exists = true;
                            break;
                        } else {
                            alert("Added to cart")
                            item.qty++;
                            exists = true;
                            break;
                        }
                        
                    }
                }

                if (!exists) {
                    if(response >= 1){
                        let newProduct = { pid: parseInt(pid), qty: 1, price: parseInt(price) };
                        cart.push(newProduct)
                        alert("Added to cart")
                    }else{
                        alert("exceeded available quantity")
                    }
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                

            } else {
                console.log("Error sending deletion request. Status code: " + xhr.status);
            }
        }
    };

    xhr.onerror = function () {
        console.log("Error sending deletion request.");
    };

    var data = "pid=" + encodeURIComponent(pid);
    xhr.send(data);




}