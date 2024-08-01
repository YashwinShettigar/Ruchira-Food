<!-- this is home section for admin panel -->



<?php


// session_start();


// // to kill session
// if (!isset($_SESSION['username'])) {
//     header("Location: admin.php");
//     exit();
// }

// if (isset($_POST['logout'])) {
//     session_unset();
//     session_destroy();
//     header("Location: admin.php");
//     exit();
// }

// connecting to database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "food_orders";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to count total orders
$sql = "SELECT COUNT(DISTINCT order_number) AS total_orders FROM orders";
$result = $conn->query($sql);

if ($result === false) {
  // Handle SQL query error
  die("Error executing query: " . $conn->error);
}

// Check if any rows are returned
if ($result->num_rows > 0) {
  // Fetch the result row
  $row = $result->fetch_assoc();
  $total_orders = $row["total_orders"];
} else {
  $total_orders = 0;
}

// Close database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Panel</title>
  <link rel="stylesheet" href="Dashboard.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-..(hash)..">


  <style>
    #logout_text {
      font-weight: 600;
    }

    #logout_container:hover {
      color: #c82333;
      font-weight: 600;
    }

    #logout_container {
      margin-top: 450px;
    }

    h3{
      color: #c82333;
      font-weight: bolder;
    }
    h4{
      color:black;
    }
  </style>

</head>

<body>
  <div class="container">
    <aside>
      <ul>
        <li><a href="#" class="logo">
            <img src="img/logo.png" alt="">
            <span class="aside-item"><span class="special-span"></span>RUCHIRA</span>
          </a></li>
        <li><a href="#" class="aside-link" data-target="home">
            <i class="fas fa-home"></i>
            <span class="aside-item">Home</span>
          </a></li>
        <li><a href="B.php" class="aside-link">
            <i class="fas fa-user"></i>
            <span class="aside-item">Order Details</span>
          </a></li>

        <li><a href="admin.php" class="aside-link" data-target="home" id="logout_container" onclick="return confirmLogout()">
            <i class="fas fa-sharp fa-solid fa-right-from-bracket"></i>
            <span class=" aside-item" id="logout_text">Logout</span>
          </a></li>

      </ul>
    </aside>



    <section class="main">
      <nav style="height: 70px; background-color:#fff; width: 100%; padding-left:30px; padding: 20px;">
        <h1>ADMIN HOME SECTION</h1>
        <!-- <i class="fas fa-user-cog"></i> -->
      </nav>

      <section id="home" class="main-content">
        <section class="main-skills">
          <div class="card">
            <i class=""></i>
            <h3>Number of Orders</h3>
          
            <button><?php echo "Total Orders: " . $total_orders; ?></button>
          </div>
          <div class="card">
            <i class=""></i>
            <h3>Number of restaurant under us</h3>
            
           <h4>
            34
           </h4>
          </div>
        </section>
        <section class="todo-list">
          <h2>To-Do List</h2>
          <ul id="todoItems">
          </ul>
          <div class="add-task">
            <input type="text" id="taskInput" placeholder="Add new task...">
            <button id="addTaskBtn">Add Task</button>
        </section>
      </section>
    </section>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.aside-link');
      const mainContents = document.querySelectorAll('.main-content');
      const homeSection = document.getElementById('home');

      // Activate the home section by default
      homeSection.classList.add('active');

      navLinks.forEach(function(navLink) {
        navLink.addEventListener('click', function() {
          const targetId = navLink.getAttribute('data-target');
          mainContents.forEach(function(content) {
            if (content.id === targetId) {
              content.classList.add('active');
            } else {
              content.classList.remove('active');
            }
          });
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const defaultTasks = ["Make more precious dishes"];

      defaultTasks.forEach(function(taskText) {
        const listItem = createTodoItem(taskText);
        todoItems.appendChild(listItem);
      });
    });

    function createTodoItem(taskText) {

      const listItem = document.createElement('li');
      listItem.textContent = taskText;

      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'Remove';
      removeBtn.classList.add('remove-btn');


      removeBtn.addEventListener('click', function() {
        listItem.remove();
      });
      listItem.appendChild(removeBtn);

      return listItem;
    }

    addTaskBtn.addEventListener('click', function() {
      const taskText = taskInput.value.trim();
      if (taskText !== '') {
        const listItem = createTodoItem(taskText);
        todoItems.appendChild(listItem);
        taskInput.value = '';
      }
    });

    function confirmLogout() {
      var confirmLogout = confirm("Are you sure you want to logout?");
      if (confirmLogout) {
        return true;
      } else {
        return false;
      }
    }
  </script>
</body>

</html>


