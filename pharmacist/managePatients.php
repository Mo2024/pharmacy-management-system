<?php $title = "Manage Patients"; require('../partials/boilerplate.inc.php')?>
<?php require('../controllers/pharmacist/managePatients.inc.php')?>
<style>
thead
{
    background-color: #3C486B;
    color: white;
}
</style>
<div class="mt-4 container">
  <div class="table-responsive">
    <table class="table table-bordered border border-dark text-center">

      <thead>
        <tr >
          <th  scope="col" colspan="4">Patients List</th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th>Username</th>
          <th>Date Created</th>
          <th>Edit Patient Info</th>
          <th>Delete Patient</th>
        </tr>
        
        <?php foreach ($rows as $row) { ?>
          <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['dateCreated'];?></td>
            <td><a type="button" href="/pharmacy-management-system/pharmacist/editPatient.php?patientId=<?php echo $row['uid'] ?>" class="btn btn-sm btn-outline-secondary">Edit Patient</a></td>
            <td><button type="button" class="btn btn-sm btn-danger">Delete Patient</button></td>
          </tr>
        <?php } ?>

      </tbody>

      </table>
    </div>
    <div class="d-flex mb-3">
      <button type="button" class="ms-auto border-0">
        <a class="text-decoration-none btn btn-sm btn-primary ms-auto" href="/pharmacy-management-system/pharmacist/addPatient.php">Add Patient</a>
        <a class="text-decoration-none btn btn-sm btn-outline-primary ms-auto" href="/pharmacy-management-system/mainpage.php">Return To Home Page</a>
      </button>
    </div>
</div>

<?php require('../partials/footer.inc.php')?>