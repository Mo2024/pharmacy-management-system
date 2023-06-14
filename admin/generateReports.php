<?php $title = "Generate Reports"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/admin/generateReports.inc.php')?>
<style>
    thead {
        background-color: #3C486B;
        color: white;
    }
</style>
<div class="mt-4 container">
    <div class="table-responsive">
        <table class="table table-bordered border border-dark text-center">
            <thead>
                <tr>
                    <th colspan="2">Reports</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Report</th>
                    <th>Generate</th>
                </tr>
                <tr>
                    <td>Sales Revenue Per Year</td>
                    <td><a type="button" href="/pharmacy-management-system/admin/salesRevenuPerYear.php" target="_blank" class="btn btn-sm btn-primary">Generate Report</a></td>
                </tr>
                <tr>
                    <td>Latest Medicine Added</td>
                    <td><a type="button" href="/pharmacy-management-system/admin/latestMedicine.php" target="_blank" class="btn btn-sm btn-primary">Generate Report</a></td>
                </tr>
                <tr>
                    <td>Top Products Ordered</td>
                    <td><a type="button" href="/pharmacy-management-system/admin/topProducts.php" target="_blank" class="btn btn-sm btn-primary">Generate Report</a></td>
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
<?php require('../partials/footer.inc.php')?>