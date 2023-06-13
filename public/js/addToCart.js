function handleCart(pid, price, dbQty) {
    let exists = false;
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    for (const item of cart) {
        if (item.pid == pid) {
            if (parseInt(item.qty) >= parseInt(dbQty)) {
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
        let newProduct = { pid: parseInt(pid), qty: 1, price: parseInt(price), dbQty: dbQty };
        cart.push(newProduct)
    }
    localStorage.setItem('cart', JSON.stringify(cart));
}