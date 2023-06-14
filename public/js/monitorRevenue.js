function getRevenue() {
    var year = document.getElementById("yearSelect").value;
    var month = document.getElementById("monthSelect").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/pharmacy-management-system/controllers/pharmacist/monitorRevenue.inc.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Request completed successfully
                const response = JSON.parse(xhr.responseText);
                let tBodyEl = document.getElementsByTagName('tbody')[0];
                tBodyEl.innerHTML = '';
                
                let row = document.createElement('tr');
                let firstCell = document.createElement('th');
                let secondCell = document.createElement('th');
                let thirdCell = document.createElement('th');
              
                firstCell.textContent = 'Order No.';
                secondCell.textContent = "Date Ordered";
                thirdCell.textContent = 'Amount';
              
                row.appendChild(firstCell);
                row.appendChild(secondCell);
                row.appendChild(thirdCell);
              
                tBodyEl.appendChild(row);
                if(response.length > 0){
                    let totalRevenue = 0
                    for (let i = 0; i < response.length; i++) {
                        let order = response[i];
                      
                        let row = document.createElement('tr');
                        let orderNoCell = document.createElement('td');
                        let dateOrderedCell = document.createElement('td');
                        let amountCell = document.createElement('td');
                      
                        orderNoCell.textContent = order.oid;
                        dateOrderedCell.textContent = order.orderDate;
                        amountCell.textContent = `$${order.totalPrice.toFixed(2)}`;
                      
                        row.appendChild(orderNoCell);
                        row.appendChild(dateOrderedCell);
                        row.appendChild(amountCell);
                      
                        tBodyEl.appendChild(row);
                        totalRevenue = totalRevenue + order.totalPrice
                    }
                    let totalRow = document.createElement('tr');
                    let totalLabelCell = document.createElement('td');
                    let totalEmptyCell = document.createElement('td');
                    let totalAmountCell = document.createElement('td');

                    totalLabelCell.textContent = 'Total Revenue';
                    totalEmptyCell.textContent = '';
                    totalAmountCell.textContent = `$${totalRevenue.toFixed(2)}`;

                    totalRow.appendChild(totalLabelCell);
                    totalRow.appendChild(totalEmptyCell);
                    totalRow.appendChild(totalAmountCell);

                    tBodyEl.appendChild(totalRow);
                }

            } else {
                console.log("Error sending request. Status code: " + xhr.status);
            }
        }
    };

    xhr.onerror = function () {
        // Request error occurred
        console.log("Error sending deletion request.");
        // You can add any additional error handling code here
    };

    var data = "month=" + encodeURIComponent(month) + "&year=" + encodeURIComponent(year);
    xhr.send(data);

}
