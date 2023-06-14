<?php $title = "Monitor Revenue"; require('../partials/boilerplate.inc.php') ?>
<style>
    thead {
        background-color: #3C486B;
        color: white;
    }
</style>
<div class="mt-4 container">
    <div class="d-flex justify-content-center">
        <div class="w-50">
            <div class="mb-2 me-2">
                <label for="yearSelect" class="form-label">Year:</label>
                <select class="form-select" id="yearSelect" onchange="getRevenue()">
                    <option value="">Select Year</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            <div class="mb-2 me-2">
                <label for="monthSelect" class="form-label">Month:</label>
                <select class="form-select" id="monthSelect" onchange="getRevenue()">
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered border border-dark text-center">
            <thead>
                <tr>
                    <th colspan="3">Revenue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Order No.</th>
                    <th>Date Ordered</th>
                    <th>Amount</th>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex mb-3">
        <div class="ms-auto border-0">
            <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
        </div>
    </div>
</div>

<script src="/pharmacy-management-system/public/js/monitorRevenue.js"></script>

<?php require('../partials/footer.inc.php') ?>
