<?php 
session_start();
if(empty($_SESSION['user_id'])) {
  header("Location: index.php");
}

// if($_SERVER['REQUEST_METHOD'] == "POST"){
//   if(isset($_POST["logout"]) && isset($_SESSION['user_id'])){
//       $_SESSION = array();
//       session_destroy();
//      foreach ($_COOKIE as $key => $value) {
//         setcookie($key, '', time() - 3600, '/', '', false, true);
//     }
//       header("Location: index.php");
//       exit;
//   } else {
//       header("Location: index.php");
//       exit;
//   }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expense Monitoring Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Sidebar styles */
    .sidebar {
      transition: transform 0.3s ease;
    }
    .sidebar-closed {
      transform: translateX(-100%);
    }

    @media print {
    .no-print {
        display: none;
    }
    
    body {
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .bg-white {
        box-shadow: none;
    }

    .rounded-lg {
        border-radius: 0;
    }

    .p-6 {
        padding: 0;
    }
}
  </style>
</head>
<body class="bg-gray-100">
<nav class="bg-[rgba(1,_60,_104,_1)] p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-white text-2xl font-bold">Expense Monitor</h1>
      <button id="menu-btn" class="text-white md:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
      <div class="hidden md:flex items-end space-x-4">
        <a href="logout.php" class=" text-white font-bold py-2 rounded">Logout</a>
        <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" class="inline-block">
                <input type="hidden" name="Logout" value="1">
                <button class=" text-white font-bold py-2 rounded">Logout</button>
        </form> -->
      </div>
    </div>
  </nav>