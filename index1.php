<?php
include('utils/functions.php');
session_start();

// Validar si el usuario está logueado o no
$isLoggedIn = isset($_SESSION['user']);
$isAdmin = $isLoggedIn && ($_SESSION['user']['role'] == 'admin');
$error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>

<?php require('inc/header.php') ?>

<div class="container-fluid">
  <?php if (!$isLoggedIn): ?>
    <!-- Si no está logueado, mostrar el formulario de login -->
    <div class="jumbotron">
      <h1 class="display-4">Login</h1>
      <p class="lead">User Login</p>
      <hr class="my-4">
    </div>
    <form method="post" action="actions/login.php">
      <div class="error">
        <?php echo $error_msg; ?>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" class="form-control" type="text" name="username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" class="form-control" type="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  <?php else: ?>
    <!-- Si está logueado, mostrar el panel de administración -->
    <div class="jumbotron">
      <h1 class="display-4">Panel de Gestión de Usuarios</h1>
      <p class="lead">Administra los usuarios del sistema</p>
      <hr class="my-4">
    </div>

    <!-- Botones CRUD visibles para todos, pero funcionales solo para admin -->
    <div class="crud-buttons">
      <?php if ($isAdmin): ?>
        <a href="add_user.php" class="btn btn-success">Agregar Usuario</a>
      <?php endif; ?>
    </div>

    <!-- Lista de usuarios visible para todos -->
    <h3>Lista de Usuarios</h3>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Email</th>
          <th>Rol</th>
          <?php if ($isAdmin): ?>
            <th>Acciones</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
          // Obtener todos los usuarios
          $users = getUsers();
          foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['firstName']}</td>";
            echo "<td>{$user['lastName']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['role']}</td>";
            if ($isAdmin) {
              echo "<td>
                      <a href='edit_user.php?id={$user['id']}' class='btn btn-warning btn-sm'>Editar</a>
                      <a href='actions/delete_user.php?id={$user['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro?\")'>Eliminar</a>
                    </td>";
            }
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>

    <!-- Botón de logout -->
    <form method="post" action="actions/logout.php">
      <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
    </form>
  <?php endif; ?>
</div>

<?php require('inc/footer.php') ?>
