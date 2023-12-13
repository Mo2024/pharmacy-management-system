function getQuantityByPID(productsArray, pid) {
    const product = productsArray.find(item => parseInt(item.pid) === pid);
    return product ? product.qty : 0;
}

var xhr = new XMLHttpRequest();
xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/main/getCart.inc.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            // Request completed successfully
            var response = xhr.responseText;
            if (response == 'empty') {

            } else {
                let cart = JSON.parse(response);
                let localCart = JSON.parse(localStorage.getItem('cart'))
                let mainContainer = document.getElementById('mainContainer');
                let totalAmount = 0;
                for (const item of cart) {
                    let qty = getQuantityByPID(localCart, item.pid)

                    var imageUrl = '/pharmacy-management-system/public/products/' + item.pid + '.jpg';
                    fetch(imageUrl, { method: 'HEAD' })
                        .then(function (response) {
                            let src = '';
                            if (response.ok) {
                                src = '/pharmacy-management-system/public/products/' + item.pid + '.jpg';
                            } else {
                                src = '/pharmacy-management-system/public/imgs/no.png';
                            }
                            let itemDiv =
                                `<div id="div${item.pid}" class="card mb-3 mt-3 w-75">
                            <div class="row">
                            <div class="col-md-3">
                                <img src="${src}" alt="" class="img-fluid h-100 w-100">
                            </div>
                                <div class="col-md-8 mt-5">
                                    <div class="card-body">
                                        <h3 class="card-title">${item.name}</h3>
                                        <h4 id="price${item.pid}" class="card-title">Total Price: $${item.price * qty}</h4>
                                        <div class="input-group w-50">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseValue(${item.pid})">-</button>
                                            </span>
                                            <input id="${item.pid}" type="number" class="form-control qty text-center w-25"  value="${qty}" onchange="handleQtyUpdate(this.id, this.value)"  min="1">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-outline-secondary" onclick="increaseValue(${item.pid})">+</button>
                                            </span>
                                        </div>
                                        <button onclick="deleteItem(${item.pid})" type="button" id="closeButton" class="btn btn-danger mt-3">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>`
                            mainContainer.innerHTML += itemDiv;
                        })
                        .catch(function (error) {
                            console.log('Error:', error);
                        });
                    totalAmount = totalAmount + (item.price * qty)
                }
                let totalAmountEl = document.getElementById('totalBill')
                totalAmountEl.innerHTML = `Total Amount: $${totalAmount}`
            }

        } else {
            console.log("Error sending deletion request. Status code: " + xhr.status);
        }
    }
};

xhr.onerror = function () {
    console.log("Error sending deletion request.");
};

var data = "cart=" + encodeURIComponent(localStorage.getItem('cart'));
xhr.send(data);

function handleQtyUpdate(id, qty, isDecrease = false) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let updatedCart = [];

    if (qty <= 0) {
        // Delete div and remove item from cart
        let divId = 'div' + id;
        let divElement = document.getElementById(divId);

        if (divElement) {
            divElement.remove();
        }

        updatedCart = cart.filter((item) => parseInt(item.pid) !== parseInt(id));
        if (updatedCart.length == 0) {
            let checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = true;
        }
        localStorage.setItem('cart', JSON.stringify(updatedCart));
    } else {

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/ajax/checkStock.inc.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Request completed successfully
                    let exists = false;
                    var cart = JSON.parse(localStorage.getItem('cart'));

                    var response = parseInt(xhr.responseText);
                    let totalAmount = 0;
                    let exceeds = false
                    updatedCart = cart.map((item) => {
                        if (parseInt(item.pid) === parseInt(id)) {
                            if (parseInt(item.qty) >= response && !isDecrease) {
                                alert("exceeded available quantity")
                                let inputQty = document.getElementById(item.pid)
                                inputQty.value = response;
                                exceeds = true
                            } else {
                                let price = document.getElementById('price' + id)
                                price.innerHTML = `Total Price: $${parseInt(item.price) * qty}`
                                totalAmount = totalAmount + (parseInt(item.price) * qty)
                                return { ...item, qty: qty };
                            }
                        } else {
                            totalAmount = totalAmount + (parseInt(item.price) * item.qty)
                        }
                        return item;
                    });
                    if (!exceeds) {
                        let totalAmountEl = document.getElementById('totalBill')
                        totalAmountEl.innerHTML = `Total Amount: $${totalAmount}`
                    }

                    localStorage.setItem('cart', JSON.stringify(updatedCart));

                } else {
                    console.log("Error sending deletion request. Status code: " + xhr.status);
                }
            }
        };

        xhr.onerror = function () {
            console.log("Error sending deletion request.");
        };

        var data = "pid=" + encodeURIComponent(parseInt(id));
        xhr.send(data);


    }

}

function increaseValue(id) {
    let qtyInput = document.getElementById(id);
    if (qtyInput) {
        let qty = parseInt(qtyInput.value) + 1;
        qtyInput.value = qty;
        handleQtyUpdate(id, qty);
    }
}

function decreaseValue(id) {
    let qtyInput = document.getElementById(id);
    if (qtyInput) {
        let qty = parseInt(qtyInput.value) - 1;
        qtyInput.value = qty;
        handleQtyUpdate(id, qty, true);
    }
}

function openPaymentMethodSelection() {
    const paymentOverlay = document.getElementById('paymentOverlay');
    const closeButton = document.getElementById('closeButton');

    paymentOverlay.style.display = 'flex';
    document.body.classList.add('modal-open');

    closeButton.addEventListener('click', () => {
        paymentOverlay.style.display = 'none';
        document.body.classList.remove('modal-open');
    });

    paymentOverlay.addEventListener('click', (event) => {
        if (event.target !== paymentOverlay) {
            event.preventDefault();
            event.stopPropagation();
        }
    });
}


function handlePaymentSubmission(event) {
    event.preventDefault();

    const cartInput = document.getElementById('cartInput');
    const cart = localStorage.getItem('cart');
    cartInput.value = cart;

    const paymentForm = document.getElementById('paymentForm');
    paymentForm.submit();
}


window.addEventListener('load', function () {
    let cart = JSON.parse(localStorage.getItem('cart'));
    if (cart === null || cart.length === 0) {
        document.getElementById('checkoutBtn').disabled = true;
        document.getElementById('submitBtn').disabled = true;
    }
});


function deleteItem(id) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let updatedCart = cart.filter(item => item.pid !== id);
    let totalAmount = 0;

    for (let item of updatedCart) {
        totalAmount += item.qty * item.price;
    }

    let totalAmountEl = document.getElementById('totalBill')
    totalAmountEl.innerHTML = `Total Amount: $${totalAmount}`

    localStorage.setItem('cart', JSON.stringify(updatedCart));

    let divId = 'div' + id;
    let divElement = document.getElementById(divId);
    if (divElement) {
        divElement.remove();
    }

}
