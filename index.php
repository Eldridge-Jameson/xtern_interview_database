<?php
	$db = new PDO('sqlite:game_list_v1.db');
	$sql = "PRAGMA foreign_keys = ON;";
	$statement = $db->prepare($sql);
	$statement->execute();
?>

<html>
<head>
<title>
Hello VVorld
</title>
</head>



<body>

<h1>Games List Database</h1>



<div style="position: absolute; left: 0; width: 25%;">
<p>SELECT</p>

<form method='POST'>
	<input type="submit" id="select_game_list" name="select_game_list" value="Select Game List">
</form>

<form method='POST'>
	<input type="submit" id="view_third_party" name="view_third_party" value="Select Third Party Games">
</form>

<?php
	if (isset($_POST['select_game_list'])) {
		try {
			$sql = "SELECT * FROM game_list;";

			$statement = $db->prepare($sql);
			$statement->execute();
			$result = $statement->fetchAll();
			
			foreach ($result as $row) {
				echo $row[0]."<br>".$row[1]."<br>".$row[2]."<br>".$row[3]."<br>".$row[4]."<br>";
				echo $row[5]."<br>".$row[6]."<br><br>";
			}
		} catch(PDOException $error) {
			echo $sql . "<br>" . $error->getMessage();
		}
	}
	//Note: Create view with "CREATE VIEW [name] AS SELECT [columns] FROM [tables];"
	//This view is of all games not published by the developers of the consoles they're on.
	//Third party games, as it were.
	if (isset($_POST['view_third_party'])) {
		try {
			$sql = "SELECT * FROM third_party;";

			$statement = $db->prepare($sql);
			$statement->execute();
			$result = $statement->fetchAll();

			foreach ($result as $row) {
				echo $row[0]."<br>".$row[1]."<br>".$row[2]."<br>".$row[3]."<br>".$row[4]."<br>";
				echo $row[5]."<br>".$row[6]."<br><br>";
			}
		} catch(PDOException $error) {
			echo $sql . "<br>" . $error->getMessage();
		}
	}
?>
</div>



<div style="position: absolute; left: 25%; width: 25%;">
<p>INSERT</p>

<form method='POST'>
	<input type="submit" id="insert" name="insert" value="Insert Game"><br><br>
	<label>Title:</label><br>
	<input type="text" id="title" name="title"><br>
	<label>Primary Development Team:</label><br>
	<input type="text" id="developer" name="developer"><br>
	<label>Publisher:</label><br>
	<input type="text" id="publisher" name="publisher"><br>
	<label>Release Date:</label><br>
	<input type="date" id="release_date" name="release_date"><br>
	<label>Genre:</label><br>
	<input type="text" id="genre" name="genre"><br>
	<label>Console:</label><br>
	<select id="console" name="console">
		<option value=''>Select a console!</option>
		<?php
		$sql = "SELECT * FROM console;";
		$statement = $db->query($sql);
		$result = $statement->fetchAll();

		foreach($result as $row) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		?>
	</select><br>
	<label>Series:</label><br>
	<input type="text" id="series" name="series">
</form>

<?php
	if (isset($_POST['insert'])) {
		try {
			$sql = "INSERT INTO game_list VALUES(:title, :developer, :publisher, :release_date, :genre, :console, :series);";

			$statement = $db->prepare($sql);
			
			$title = $_POST['title'];
			$developer = $_POST['developer'];
			$publisher = $_POST['publisher'];
			$release_date = $_POST['release_date'];
			$genre = $_POST['genre'];
			$console = $_POST['console'];
			$series =  $_POST['series'];
			
			$statement->bindParam(':title', $title);
			$statement->bindParam(':developer', $developer);
			$statement->bindParam(':publisher', $publisher);
			$statement->bindParam(':release_date', $release_date);
			$statement->bindParam(':genre', $genre);
			$statement->bindParam(':console', $console);
			$statement->bindParam(':series', $series);
			$statement->execute();
			$result = $statement->fetchAll();

			//<pre> describes preformatted text.
			//print_r() displays array contents in a human-readable format.

			echo $title . " has been entered!";
		} catch(PDOException $error) {
			echo $sql . "<br>" . $error->getMessage();
		}
	}
?>
</div>



<div style="position: absolute; left: 50%; width: 25%;">

<p>UPDATE</p>

<form method="POST">
	<input type="submit" id="update" name="update" value="Update Game"><br><br>
	<label>Game:</label><br>
	<select id="title" name="title">
		<option value=''>Select a game!</option>
		<?php
		$sql = "SELECT * FROM game_list;";
		$statement = $db->query($sql);
		$result = $statement->fetchAll();

		foreach($result as $row) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		?>
	</select><br><br>
	<label>Columns to Update:</label><br>

	<input type="checkbox" id="developerCheck" name="developerCheck" onclick="toggleReveal('developerUpdate')">
	<label for="developerCheck">Developer</label><br>
	<input type="text" id="developerUpdate" name="developerUpdate" style="display: none;">

	<input type="checkbox" id="publisherCheck" name="publisherCheck" onclick="toggleReveal('publisherUpdate')">
	<label for="publisherCheck">Publisher</label><br>
	<input type="text" id="publisherUpdate" name="publisherUpdate" style="display: none;">

	<input type="checkbox" id="release_dateCheck" name="release_dateCheck" onclick="toggleReveal('release_dateUpdate')">
	<label for="release_dateCheck">Release Date</label><br>
	<input type="date" id="release_dateUpdate" name="release_dateUpdate" style="display: none;">

	<input type="checkbox" id="genreCheck" name="genreCheck" onclick="toggleReveal('genreUpdate')">
	<label for="genreCheck">Genre</label><br>
	<input type="text" id="genreUpdate" name="genreUpdate" style="display: none;">

	<input type="checkbox" id="consoleCheck" name="consoleCheck" onclick="toggleReveal('consoleUpdate')">
	<label for="consoleCheck">Console</label><br>
	<select id="consoleUpdate" name="consoleUpdate" style="display: none;">
		<option value=''>Select a console!</option>
		<?php
		$sql = "SELECT * FROM console;";
		$statement = $db->query($sql);
		$result = $statement->fetchAll();

		foreach($result as $row) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		?>
	</select>

	<input type="checkbox" id="seriesCheck" name="seriesCheck" onclick="toggleReveal('seriesUpdate')">
	<label for="seriesCheck">Series</label><br>
	<input type="text" id="seriesUpdate" name="seriesUpdate" style="display: none;">
</form>

<?php
	if(isset($_POST['update'])) {
		try {
			$title = $_POST['title'];
			echo "Updated ".$title." with:<br>";

			if ($_POST['developerCheck']) {
				$sql = "UPDATE game_list SET developer=:developer WHERE title=:title;";
				$statement = $db->prepare($sql);

				$developer = $_POST['developerUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':developer', $developer);

				$statement->execute();
				echo "developer = ".$developer."<br>";
			}
				if ($_POST['publisherCheck']) {
				$sql = "UPDATE game_list SET publisher=:publisher WHERE title=:title;";
				$statement = $db->prepare($sql);

				$publisher = $_POST['publisherUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':publisher', $publisher);

				$statement->execute();
				echo "publisher = ".$publisher."<br>";
			}
			if ($_POST['release_dateCheck']) {
				$sql = "UPDATE game_list SET release_date=:release_date WHERE title=:title;";
				$statement = $db->prepare($sql);

				$release_date = $_POST['release_dateUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':release_date', $release_date);

				$statement->execute();
				echo "release_date = ".$release_date."<br>";
			}
			if ($_POST['genreCheck']) {
				$sql = "UPDATE game_list SET genre=:genre WHERE title=:title;";
				$statement = $db->prepare($sql);

				$genre = $_POST['genreUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':genre', $genre);

				$statement->execute();
				echo "genre = ".$genre."<br>";
			}
			if ($_POST['consoleCheck']) {
				$sql = "UPDATE game_list SET console=:console WHERE title=:title;";
				$statement = $db->prepare($sql);

				$console = $_POST['consoleUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':console', $console);

				$statement->execute();
				echo "console = ".$console."<br>";
			}
			if ($_POST['seriesCheck']) {
				$sql = "UPDATE game_list SET series=:series WHERE title=:title;";
				$statement = $db->prepare($sql);

				$series = $_POST['seriesUpdate'];
				
				$statement->bindParam(':title', $title);
				$statement->bindParam(':series', $series);

				$statement->execute();
				echo "series = ".$series;
			}
		} catch (PDOException $error) {
			echo $sql . "<br>" . $error->getMessage();
		}
	}
?>

</div>



<div style="position: absolute; left: 75%; width: 25%;">

<p>DELETE</p>

<form method="POST">
	<input type="submit" id="delete" name="delete" value="Delete Game"><br><br>
	<label>Game:</label><br>
	<select id="title" name="title">
		<option value=''>Select a game!</option>
		<?php
		$sql = "SELECT * FROM game_list;";
		$statement = $db->query($sql);
		$result = $statement->fetchAll();

		foreach($result as $row) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		?>
	</select>
</form><br><br>

<?php
	if (isset($_POST['delete'])) {
		try {
			$sql = "DELETE FROM game_list WHERE title=:title;";
			$title = $_POST['title'];

			$statement = $db->prepare($sql);
			$statement->bindParam(':title', $title);

			$statement->execute();
			echo $title . " deleted.";
		} catch (PDOException $error) {
			echo $sql . "<br>" . $error->getMessage();
		}
	}
?>

</div>



<script>
	function toggleReveal(id) {
		var division = document.getElementById(id);
		if (division.style.display ==="none") {
			division.style.display = "block";
		} else {
			division.style.display = "none";
		}
	}
</script>



</body>
</html> 
