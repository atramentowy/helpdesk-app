<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "helpdesk");

$sql = "SELECT id, title, description, status, priority, created_at FROM tickets";
$result = mysqli_query($conn, $sql);

$users = "SELECT id FROM users";
$result2 = mysqli_query($conn, $users);
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
				<h3>Admin dashboard</h3>
				<nav>
					<ul>
						<li><a href="#" onclick="showDiv('zgloszenia')">Zgłoszenia</a></li>
						<li><a href="#" onclick="showDiv('nowe-zgloszenie')">Nowe zgłoszenie</a></li>
						<li><a href="#" onclick="showDiv('uzytkownicy')">Użytkownicy</a></li>
						<li><a href="#" onclick="showDiv('profil')">Profil</a></li>
						<li><a href="logout.php">Wyloguj</a></li>
					</ul>
				</nav>
			</section>
		</aside>
		<main class="content">
			<div id="zgloszenia" class="section">
				<h2>Zgłoszenia</h2>
				<section>
					<div class="search">
						<form id="searchForm">
							<label for="status">Status:</label>
							<select id="status" name="status">
							  <option value="wstrzymane">Wstrzymane</option>
							  <option value="w-toku">W toku</option>
							  <option value="rozwiazane">Rozwiązane</option>
							</select>
							<label for="priority">Priorytet:</label>
							<select id="priority" name="priority">
							  <option value="wysoki">Wysoki</option>
							  <option value="sredni">Średni</option>
							  <option value="niski">Niski</option>
							</select>
							<input type="text" id="searchInput" placeholder="Szukaj...">
							<input type="submit" value="Szukaj">
						</form>
					</div>
					<?php while ($row = mysqli_fetch_assoc($result)) { ?>

					    <article class="ticket">
							<table class="ticket">
							    <tr>
							    	
							        <th colspan="4">Tytuł: <?= htmlspecialchars($row['title']) ?>
							        </th>
							    </tr>
							    <tr>
							    	<td>Id: <?= $row['id'] ?></td>
							        <td>Status: <?= $row['status'] ?></td>
							        <td>Priorytet: <?= $row['priority'] ?></td>
							        <td>Data utworzenia: <?= $row['created_at'] ?></td>
							    </tr>
							    <tr>
							        <td colspan="4">Opis: <?= htmlspecialchars($row['description']) ?>
							        </td>
							    </tr>
							</table>
							<button>Edytuj</button>
					    </article>
					<?php } ?>
				</section>
			</div>
			<div id="uzytkownicy" class="section hidden">
				<h2>Użytkownicy</h2>
				<section>
					<?php while ($row = mysqli_fetch_assoc($result2)) { ?>
						<?=$row['id']?>
					<?php } ?>
				</section>
			</div>
			<div id="nowe-zgloszenie" class="section hidden">
				<h2>Nowe zgłoszenie</h2>
				<section>
					<form id="newTicketForm">
						<label for="title">Tytuł zgłoszenia:</label>
						<input type="text" id="title" name="title" placeholder="tytuł zgloszenia">
<!-- 						<label for="status">Status zgłoszenia:</label>
						<select id="status" name="status">
						  <option value="wstrzymane">Wstrzymane</option>
						  <option value="w-toku">W toku</option>
						  <option value="rozwiazane">Rozwiązane</option>
						</select><br> -->
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
			</div>
			<script src="script.js"></script>
		</main>
	</div>
	<footer>
		<p>&copy; 2026 Helpdesk App</p>
	</footer>
</body>
</html>
