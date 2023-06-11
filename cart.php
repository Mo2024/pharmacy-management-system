<?php $title = "Cart"; require('partials/boilerplate.inc.php')?>
<style>
thead
@media (max-width: 576px) {
  .w-xs-50{
    width: 50%
  }
}
@media (min-width: 576px) {
  .w-md-50{
    width: 27.5%
  }
}
</style>
<script>
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
            if(response == 'empty'){

            }else{
                let cart = JSON.parse(response);
                let localCart = JSON.parse(localStorage.getItem('cart'))
                let mainContainer = document.getElementById('mainContainer');
                for(const item of cart){

                    var imageUrl = '/pharmacy-management-system/public/products/' + item.pid + '.jpg';
                    fetch(imageUrl, { method: 'HEAD' })
                    .then(function(response) {
                        let src = '';
                        if (response.ok) {
                            src = '/pharmacy-management-system/public/products/' + item.pid + '.jpg';
                        } else {
                            src = '/pharmacy-management-system/public/imgs/no.png';
                        }
                        let qty = getQuantityByPID(localCart, item.pid)
                        let itemDiv = 
                        `<div id="div${item.pid}" class="card mb-3 mt-3 w-75">
                            <div class="row">
                            <div class="col-md-3">
                                <img src="${src}" alt="" class="img-fluid h-100 w-100">
                            </div>
                                <div class="col-md-8 mt-5">
                                    <div class="card-body">
                                        <h3 class="card-title">${item.name}</h3>
                                        <h4 id="price${item.pid}" class="card-title">Total Price: $${item.price*qty}</h4>
                                        <div class="input-group w-50">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseValue(${item.pid})">-</button>
                                            </span>
                                            <input id="${item.pid}" type="number" class="form-control qty text-center"  value="${qty}" onchange="handleQtyUpdate(this.id, this.value)"  min="1">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-outline-secondary" onclick="increaseValue(${item.pid})">+</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
                        
                        mainContainer.innerHTML += itemDiv;
                    })
                    .catch(function(error) {
                        console.log('Error:', error);
                    });


                }
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

function handleQtyUpdate(id, qty) {
  let cart = JSON.parse(localStorage.getItem('cart'));
  let updatedCart = [];

  if (qty <= 0) {
    // Delete div and remove item from cart
    let divId = 'div' + id;
    let divElement = document.getElementById(divId);
    if (divElement) {
      divElement.remove();
    }

    updatedCart = cart.filter((item) => item.pid !== id);
  } else {

    updatedCart = cart.map((item) => {
      if (parseInt(item.pid) === parseInt(id)) {
        let price = document.getElementById('price'+id)
        price.innerHTML = `Total Price: $${parseInt(item.price)* item.qty}`
        return { ...item, qty: qty };
      }
      return item;
    });
  }

  localStorage.setItem('cart', JSON.stringify(updatedCart));
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
    handleQtyUpdate(id, qty);
  }
}
</script>

<div  class="container">
<div id="mainContainer" class="row justify-content-center">

</div>
</div>
<?php require('partials/footer.inc.php')?>