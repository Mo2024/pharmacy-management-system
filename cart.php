<?php $title = "Cart"; require('partials/boilerplate.inc.php')?>
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
                console.log(cart);

                let mainContainer = document.getElementById('mainContainer');
                for(const item of cart){

                    let qty = getQuantityByPID(localCart, item.pid)
                    let itemDiv = 
                    `<div class="card mb-3 mt-3">
                        <div class="row">
                            <div class="col-md-8 mt-5">
                                <div class="card-body">
                                    <h3 class="card-title">${item.name}</h3>
                                    <h4 class="card-title">Total Price: ${item.price*qty}</h4>
                                </div>
                            </div>
                        </div>
                    </div>`
                    
                    mainContainer.innerHTML += itemDiv;

                }
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

var data = "cart=" + encodeURIComponent(localStorage.getItem('cart'));
xhr.send(data);

</script>

<div id="mainContainer" class="container" >
</div>
<?php require('partials/footer.inc.php')?>