<?php
require('utils/functions.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = getUserById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedUser = [
            'id' => $id,
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'email' => $_POST['email'],
            'role' => $_POST['role']
        ];
        
        if (updateUser($updatedUser)) {
            header('Location: /users.php');
            exit;
        } else {
            echo "Error updating user.";
        }
    }
}
?>
<?php require('inc/header.php'); ?>
<div class="container mt-5">
  <h2>Edit User</h2>
  <form method="post">
    <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>" required>
    </div>
    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['username']; ?>" required>
    </div>
    <div class="form-group">
      <label for="role">Role</label>
      <select class="form-control" id="role" name="role">
        <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
        <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Update User</button>
  </form>
</div>
<?php require('inc/footer.php'); ?>

