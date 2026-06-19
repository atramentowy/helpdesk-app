<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST['action'] ?? '';

	$conn = mysqli_connect("localhost", "root", "", "helpdesk");
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

	if($action == 'login') {
		session_start();
	    
	    $login = $_POST['login'] ?? '';
	    $password = $_POST['password'] ?? '';

	    if (empty($login) || empty($password)) {
	        $message = "Zły login lub hasło";
	    } else {
			$stmt = mysqli_prepare(
			    $conn,
			    "SELECT id, role, password FROM users WHERE login=?"
			);

			mysqli_stmt_bind_param($stmt, "s", $login);
			mysqli_stmt_execute($stmt);

			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) == 0) {
			    $message = "Zły login lub hasło result = 0";
			} else {
			    $user = mysqli_fetch_assoc($result);

			    if(!password_verify($password, $user['password'])) {
			    	$message = "Zły login lub hasło";
			    } else {
				    $_SESSION["user_id"] = $user["id"];
				    $_SESSION["role"] = $user["role"];
				    $_SESSION["login"] = $login;

				    switch($user["role"]) {
				        case "admin":
				            header("Location: admin.php");
				            exit();

				        case "support":
				            header("Location: support.php");
				            exit();

				        case "user":
				            header("Location: user.php");
				            exit();
				    }
				}
			}
	    }
	}
	else if ($action == 'register') {
	    $login = $_POST['login'] ?? '';
	    $password = $_POST['password'] ?? '';
	    $email = $_POST['email'] ?? '';
	    $role = 'user';

	   	if (empty($login) || empty($password) || empty($email)) {
	        $message = "Pusty login, hasło lub email";
	    } else {

			$stmt = mysqli_prepare(
	            $conn,
	            "SELECT id FROM users WHERE login=?"
	        );

	        mysqli_stmt_bind_param($stmt, "s", $login);
	        mysqli_stmt_execute($stmt);

	        $result = mysqli_stmt_get_result($stmt);

	        if (mysqli_num_rows($result) > 0) {

	            $message = "Taki login już istnieje";

	        } else {
	            $hashedPassword = password_hash(
	                $password,
	                PASSWORD_DEFAULT
	            );

	            $stmt = mysqli_prepare(
	                $conn,
	                "INSERT INTO users(login, email, password, role)
	                 VALUES(?, ?, ?, 'user')"
	            );

	            mysqli_stmt_bind_param(
	                $stmt,
	                "sss",
	                $login,
	                $email,
	                $hashedPassword
	            );

	            if (mysqli_stmt_execute($stmt)) {
	                $message = "Konto utworzone";
	            } else {
	                $message = "Błąd podczas rejestracji";
	            }
	        }
		}
	}
	else if ($action == 'reset') {
	    $email = $_POST['email'] ?? '';

	    if (empty($email)) {
	    	$message = "Podaj email";
	    } else {
	    	$link = "http://localhost/helpdesk/reset.php?token=$token";

	    	mail($email, "Reset hasła", $link);

	    	$message = "Wysłano email resetujący";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96">
	<link rel="stylesheet" href="styles.css">
	<title>Helpdesk App</title>
</head>
<body>
	<div class="topbar">
		<header>
			<h1>Helpdesk App</h1>
		</header>
	</div>
	<main class="centered">
		<!-- <button onclick="test()">Kliknij</button> -->
		<p id="message" class="message"><?php echo $message; ?></p>
		<form id="login" class="form" method="POST" action="">
			<input type="hidden" name="action" value="login">
			<h2>Zaloguj się:</h2>
			<label for="login">Login:</label>
			<input type="text" id="login" placeholder="login" name="login"><br>

			<label for="password" id="email">Hasło:</label>
			<input type="text" id="password" placeholder="hasło" name="password"><br><br>

			<input type="submit" value=" Zaloguj "><br><br>
			<input type="button" value="Nie pamiętam hasła" onclick="showForm('reset')">
			<input type="button" value=" Rejestracja " onclick="showForm('register')">
			
		</form>
		<form id="reset" class="form hidden" method="POST" action="">
			<input type="hidden" name="action" value="reset">
			<h2>Odzyskaj hasło:</h2>
			<article>
			Na powiązany z kontem email zostanie wysłana wiadomość z przypomnieniem hasła.
			</article><br>
			<label for="email">Email:</label>
			<input type="text" id="email" placeholder="email" name="email"><br><br>
			<input type="button" value="Powrót do logowania" onclick="showForm('login')">

			<input type="submit" value="Wyślij przypomnienie">
		</form>
		<form id="register" class="form hidden" method="POST" action="login.php">
			<input type="hidden" name="action" value="register">
			<h2>Rejestracja:</h2>
			<label for="login">Login:</label>
			<input type="text" id="login" placeholder="login" name="login"><br>

			<label for="password" id="email">Hasło:</label>
			<input type="text" id="password" placeholder="hasło" name="password"><br>

			<label for="email">Email:</label>
			<input type="text" id="email" placeholder="email" name="email"><br><br>

			<input type="button" value="Powrót do logowania" onclick="showForm('login')">
			<input type="submit" value="Zarejestruj">
		</form>
		
	</main>
	<footer>
		<p>&copy; 2026 Helpdesk App</p>
	</footer>

	<script src="script.js"></script>
</body>
</html>
