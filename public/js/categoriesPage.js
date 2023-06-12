function handleCart(pid, price) {
    let exists = false;
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    for (const item of cart) {
        if (item.pid == pid) {
            item.qty++;
            exists = true;
            break;
        }
    }

    if (!exists) {
        let newProduct = { pid: parseInt(pid), qty: 1, price: parseInt(price) };
        cart.push(newProduct)
    }
    localStorage.setItem('cart', JSON.stringify(cart));
}