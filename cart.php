<?php $title = "Cart"; require('partials/boilerplate.inc.php')?>
<?php require('controllers/main/cart.inc.php')?>
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
.payment-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}

.payment-box {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
  max-width: 90%;
  text-align: center;
  position: relative;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}

.show-backdrop {
  pointer-events: none;
}
body.modal-open {
  overflow: hidden;
}
</style>

<div  class="container">
<h3 id="totalBill" class="text-center"></h3>

<div id="mainContainer" class="row justify-content-center">

</div>
</div>

<div id="paymentOverlay" class="payment-overlay" style="display: none;">
  <div id="paymentBox" class="payment-box">
    <h3>Select Payment Method</h3>
    <form id="paymentForm" method="post">
      <div class="payment-options">
        <select name="paymentMethod" class="form-select">
          <option value="creditCard">Credit Card</option>
          <option value="cash">Cash</option>
        </select>
        <div class="mt-3">
          <input id="cartInput" type="hidden" name="cart" value="">
        </div>
      </div>
      <div class="mt-3">
        <button id="submitBtn" name="button" onclick="handlePaymentSubmission(event)" type="submit" class="btn btn-primary">Pay Now</button>
        <button type="button" id="closeButton" class="btn btn-danger">Cancel</button>
      </div>
    </form>
  </div>
</div>






<div class="d-flex mb-3">
    <button id="checkoutBtn" onclick="openPaymentMethodSelection()" type="button" class="btn btn-sm btn-primary ms-auto">Proceed to Checkout</button>
</div>

<script src="/pharmacy-management-system/public/js/cartPage.js"></script>

<?php require('partials/footer.inc.php')?>