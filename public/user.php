<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

$conn = mysqli_connect("localhost", "root", "", "helpdesk");

$tickets_query = "SELECT id, title, description, status, priority, created_at 
		FROM tickets WHERE user_id='{$_SESSION['user_id']}'";

$profile_query = "SELECT id, login, email, role 
		FROM users WHERE id='{$_SESSION['user_id']}'";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST['action'] ?? '';

	if($action == 'search') {
		$status = $_POST['status'] ?? '';
		$priority = $_POST['priority'] ?? '';
		$search = $_POST['search'] ?? '';
		$order = $_POST['order'] ?? '';

		if($status != '') {
			$tickets_query .= " AND status='$status'";
		}

		if($priority != '') {
			$tickets_query .= " AND priority='$priority'";
		}

		if($search != '') {
			$tickets_query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
		}

		if($search != '') {
			$tickets_query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
		}

		if($order == 'ascending') {
			$tickets_query .= " ORDER BY id ASC";
		}
		else if($order == 'descending') {
			$tickets_query .= " ORDER BY id DESC";
		}
	}
	else if($action == 'ticket') {
		$title = $_POST['title'] ?? '';
		$priority = $_POST['priority'] ?? '';
		$description = $_POST['description'] ?? '';

		if(empty($_POST['title']) || 
			empty($_POST['priority']) || empty($_POST['description'])) {

			echo "Brak tytułu, priorytetu lub opisu";
		} else {
			$ticket = "INSERT INTO tickets 
				(id, user_id, title, description, status, priority, created_at)
				VALUES (NULL, {$_SESSION['user_id']}, '$title', '$description', 
				'nowe', '$priority', current_timestamp())";

			if($new_ticket_result) {
				echo "Zgłoszenie pomyślnie stworzone";
			} else {
				echo "Error";
			}

			header("Location: user.php");
			exit();
		}
	}
	else if($action == 'change_password') {
	    // Pobierz dane
	    $old = $_POST['old_password'];
	    $new = $_POST['new_password'];
	    $repeat = $_POST['repeat_password'];
	    
	    // Sprawdź czy nowe hasła pasują
	    if($new !== $repeat) {
	        $_SESSION['error'] = "Hasła nie pasują!";
	        header("Location: user.php");
	        exit();
	    }
	    
	    // Pobierz stare hasło
	    $result = mysqli_query($conn, "SELECT password FROM users WHERE id = {$_SESSION['user_id']}");
	    $user = mysqli_fetch_assoc($result);
	    
	    // Sprawdź stare hasło
	    if(!password_verify($old, $user['password'])) {
	        $_SESSION['error'] = "Stare hasło jest nieprawidłowe!";
	        header("Location: user.php");
	        exit();
	    }
	    
	    // Zapisz nowe hasło
	    $hashed = password_hash($new, PASSWORD_DEFAULT);
	    mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE id = {$_SESSION['user_id']}");
	    
	    $_SESSION['message'] = "Hasło zmienione!";
	    header("Location: user.php");
	    exit();
	}
}

$tickets_result = mysqli_query($conn, $tickets_query);
$profile_result = mysqli_query($conn, $profile_query);
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

	<div class="layout">
		<aside class="sidebar">
			<h2>Nawigacja</h2>
			<section>
				<h3>User dashboard</h3>
				<nav>
					<ul>
						<li><a href="#" onclick="showDiv('zgloszenia')">Moje zgłoszenia</a></li>
						<li><a href="#" onclick="showDiv('nowe-zgloszenie')">Nowe zgłoszenie</a></li>
						<li><a href="#" onclick="showDiv('profil')">Profil</a></li>
						<li><a href="logout.php">Wyloguj</a></li>
					</ul>
				</nav>
			</section>
		</aside>
		<main class="content">
			<div id="zgloszenia" class="section">
				<h2>Moje zgłoszenia</h2>
				<section>
					<div class="search">
						<form id="searchForm" class="form" method="POST" action="">
							<input type="hidden" name="action" value="search">
							<label for="status">Status:</label>
							<select id="status" name="status">
								<option value="">Dowolny</option>
								<option value="nowe">Nowe</option>
								<option value="wstrzymane">Wstrzymane</option>
								<option value="w_toku">W toku</option>
								<option value="zamknięte">Zamknięte</option>
							</select>
							<label for="priority">Priorytet:</label>
							<select id="priority" name="priority">
								<option value="">Dowolny</option>
								<option value="niski">Niski</option>
								<option value="sredni">Średni</option>
								<option value="wysoki">Wysoki</option>
							</select>
							<label for="order">Kolejność (id):</label>
							<select id="order" name="order">
								<option value="ascending">Rosnąca</option>
								<option value="descending">Malejąca</option>
							</select>
							<input type="text" id="search" name="search" placeholder="Szukaj...">
							<input type="submit" value="Szukaj">
						</form>
					</div>
					<?php while ($row = mysqli_fetch_assoc($tickets_result)) { ?>
					<article class="ticket">
						<table class="ticket">
							<tr>
								<th colspan="4">Tytuł: <?= htmlspecialchars($row['title']) ?></th>
							</tr>
							<tr>
								<td>Id: <?= $row['id'] ?></td>
								<td>Status: <?= $row['status'] ?></td>
								<td>Priorytet: <?= $row['priority'] ?></td>
								<td>Data utworzenia: <?= $row['created_at'] ?></td>
							</tr>
							<tr>
								<td colspan="4">Opis: <?= htmlspecialchars($row['description']) ?></td>
							</tr>
						</table>
					</article>
					<?php } ?>
				</section>
			</div>
			<div id="nowe-zgloszenie" class="section hidden">
				<h2>Nowe zgłoszenie</h2>
				<section>
					<form id="newTicketForm" class="form" method="POST" action="">
						<input type="hidden" name="action" value="ticket">

						<label for="title">Tytuł zgłoszenia:</label>
						<input type="text" id="title" name="title" placeholder="tytuł zgloszenia">
						<label for="priority">Priorytet:</label>
						<select id="priority" name="priority">
							<option value="wysoki">Wysoki</option>
							<option value="sredni">Średni</option>
							<option value="niski">Niski</option>
						</select><br>
						<label for="description">Opis zgłoszenia:</label><br>
						<textarea id="description" name="description" rows="4" cols="50" placeholder="opis zgłoszenia"></textarea><br>
						<input type="submit" value="Wyślij zgłoszenie">
					</form>
				</section>
			</div>
			<div id="profil" class="section hidden">
				<h2>Profil</h2>
				<section>
					<article>
						<?php while ($row = mysqli_fetch_assoc($profile_result)) { ?>
						<table>
							<tr>
								<td>Id: <?= $row['id'] ?></td>
							</tr>
							<tr>
								<td>Login: <?= $row['login'] ?></td>
							</tr>
							<tr>
								<td>Email: <?= $row['email'] ?></td>
							</tr>
							<tr>
								<td>Rola: <?= $row['role'] ?></td>
							</tr>
						</table>
						<?php } ?>
					</article>
					<article>
						<button type="button" onclick="showDiv('change-password')">Zmień hasło</button>
					</article>
				</section>
			</div>
			<div id="change-password" class="section hidden">
				<h2>Zmień hasło</h2>
				<section>
					<form id="changePasswordForm" method="POST" action="">
						<input type="hidden" name="action" value="change_password">
						<table>
							<tr>
								<td>Hasło: <input type="text" id="old_password" name="edit_password"></td>
							</tr>
							<tr>
								<td>Nowe hasło: <input type="text" id="new_password" name="edit_password"></td>
							</tr>
							<tr>
								<td>Powtórz hasło: <input type="text" id="repeat_password" name="edit_password"></td>
							</tr>
						</table>
						<br>
						<button type="submit">Zapisz zmiany</button>
						<button type="button" onclick="showDiv('profil')">Anuluj</button>
					</form>
				</section>
			</div>
			<script src="script.js"></script>
		</main>
	</div>
	<footer>
		<p>&copy; 2026 Helpdesk App</p>
	</footer>
</body>
</html>
