<?php
  /* start the session */
  session_start();

  /* make sure user is logged in and session variable is set*/
  if(!isset($_SESSION['email'])) {
  	header("Location: login_view.php");
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rec Sports Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
          <ul class="sidebar-nav">
              <li class="sidebar-brand">
                  <a href="home.php">
                      Rec Sports Manager
                  </a>
              </li>
              <li>
                  <a href='logout.php'>Log out</a>
              </li>
              <li>
                  <a href="home.php">Profile</a>
              </li>
              <li>
                  <a href="#">My Schedule (coming soon)</a>
              </li>
              <li>
                  <a href="create_team_view.php">Create a Team</a>
              </li>
              <li>
                  <a href="join_team_view.php">Join a Team</a>
              </li>
              <li>
                  <a href="#">Contact (coming soon)</a>
              </li>
          </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Join a team</h1>
                        <hr>
                        <?php
                        require "db.conf";

                        if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
                          /* create a prepared statement */
                          if ($stmt2 = mysqli_prepare($link, "SELECT name FROM Team WHERE name LIKE ?")){
                            /* bind variables to marker */
                            $search = "%".$_POST['search']."%";
                            mysqli_stmt_bind_param($stmt2, 's', $search);
                            /* execute query */
                            mysqli_stmt_execute($stmt2);
                            /* store result */
                            mysqli_stmt_store_result($stmt2);
                            /* bind result variables */
                            mysqli_stmt_bind_result($stmt2, $name);
                            /* print output for each result returned */
                            echo "<table>";
                            echo "<tr><th>Team</th><th></th></tr>";
                            while (mysqli_stmt_fetch($stmt2)){
                              echo "<tr><td>$name</td><td><form action='join_team_controller.php' method='POST'><input type='hidden' name='team_name' value='$name'><input type='submit' value='Join $name'></form></td></tr>";
                            }
                            echo "</table>";
                            echo "<hr>";
                            echo "</ul>";
                            echo "</div>";

                          /* close prepared statement2 */
                          mysqli_stmt_close($stmt2);

                          } else echo "Prepared statement 2 failed.";

                        }
                        ?>
                        <form action='join_team_view.php'>
                          <input type='submit' name='submit' value='Go back'>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
