<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		<form id="loginForm">
			<label for="login">Login:</label>
			<input type="text" id="login" placeholder="login"><br>

			<label for="password" id="email">Hasło:</label>
			<input type="text" id="password" placeholder="hasło"><br>

			<input type="button" value="Nie pamiętam hasła">
			<input type="submit" value="Zaloguj">
		</form>

		<form id="recoverPasswordForm">
			<label for="email">Email:</label>
			<input type="text" id="email" placeholder="email"><br>

			<input type="submit" value="Wyślij przypomnienie">
		</form>
		<article>
			Na podany email, jeśli był powiązany z kontem zostanie wysłana wiadomość z przypomnieniem hasła.
		</article>

		<form id="registerForm">
			<label for="login">Login:</label>
			<input type="text" id="login" placeholder="login"><br>

			<label for="password" id="email">Hasło:</label>
			<input type="text" id="password" placeholder="hasło"><br>

			<label for="email">Email:</label>
			<input type="text" id="email" placeholder="email"><br>

			<input type="button" value="Wróć">
			<input type="submit" value="Zarejestruj">
		</form>
	</main>
	<footer>
		<p>&copy; 2026 Helpdesk App</p>
	</footer>

	<?php
		session_start();
		$conn = new mysqli("localhost", "root", "", "helpdesk");

		if ($_POST) {
		    $username = $_POST['username'];
		    $password = $_POST['password'];

		    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
		    $user = $result->fetch_assoc();

		    if ($user) {
		        $_SESSION['user'] = $user['username'];
		        $_SESSION['role'] = $user['role'];

		        header("Location: dashboard.php");
		        exit;
		    } else {
		        echo "Błędne dane";
		    }
		}
	?>
</body>
</html>
