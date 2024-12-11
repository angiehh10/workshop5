<?php

/**
 * Obtiene las provincias desde la base de datos
 */
function getProvinces() {
  $conn = getConnection();
  $sql = "SELECT id, name FROM provinces";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
      die('Error al obtener provincias: ' . mysqli_error($conn));
  }

  $provinces = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $provinces[$row['id']] = $row['name'];
  }

  mysqli_close($conn);
  return $provinces;
}

/**
* Conexión a la base de datos
*/
function getConnection() {
  $connection = mysqli_connect('localhost', 'root', '', 'tarea5');

  if (!$connection) {
      die('Error de conexión: ' . mysqli_connect_error());
  }

  return $connection;
}
/**
 * Saves an specific user into the database
 */
function saveUser($user): bool {
  $firstName = $user['firstName'];
  $lastName = $user['lastName'];
  $username = $user['email'];
  // Usar password_hash para hashear la contraseña de forma segura
  $password = password_hash($user['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, lastname, username, password) VALUES('$firstName', '$lastName', '$username','$password')";

  try {
    $conn = getConnection();
    mysqli_query($conn, $sql);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
  return true;
}


/**
 * Get one specific student from the database
 *
 * @id Id of the student
 */
function authenticate($username, $password) {
  $conn = getConnection();

  function authenticate($username, $password) {
    $conn = new mysqli("localhost", "root", "", "tarea4");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepara y ejecuta la consulta
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $hashed_password = md5($password); // Asegúrate de usar el mismo hashing que usaste al registrar

    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Comprueba si hay un usuario
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Devuelve los datos del usuario
    } else {
        return false; // Usuario no encontrado
    }

    $stmt->close();
    $conn->close();

  }
}

function getUsers() {
  $conn = getConnection();
  $sql = "SELECT * FROM users";
  $result = mysqli_query($conn, $sql);

  $users = [];
  if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
          $users[] = $row;
      }
  }
  
  mysqli_close($conn);
  return $users;
}

function getUserById($id) {
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);
  mysqli_close($conn);
  return $user;
}

function updateUser($user) {
  $id = $user['id'];
  $firstName = $user['firstName'];
  $lastName = $user['lastName'];
  $username = $user['email'];
  $role = $user['role'];

  $conn = getConnection();
  $sql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', username = '$username', role = '$role' WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      return true;
  } else {
      mysqli_close($conn);
      return false;
  }
}

function deleteUser($id) {
  $conn = getConnection();
  $sql = "DELETE FROM users WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      return true;
  } else {
      mysqli_close($conn);
      return false;
  }
}