function handleCart(pid, price, dbQty) {
    let exists = false;
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    for (const item of cart) {
        if (item.pid == pid) {
            console.log(pid, item.pid, dbQty)
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
        let newProduct = { pid: parseInt(pid), qty: 1, price: parseInt(price) };
        cart.push(newProduct)
    }
    localStorage.setItem('cart', JSON.stringify(cart));
}