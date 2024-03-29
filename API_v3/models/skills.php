<?php
$sql = "SELECT * FROM `skills`";
$result = $conn->query($sql);
$row_count = $result->num_rows;

$skills_array = $result->fetch_all(MYSQLI_ASSOC);

// якщо немає категорій
if ($row_count == 0) {
	$skills_array = array();
	
	// Отримання даних з API
	$url = 'https://api.freelancehunt.com/v2/skills';

	$headers = array(
		'Authorization: Bearer '.$freelancehuntToken
	);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);

	// Перетворення відповіді в масив
	if ($response) {
		$data = json_decode($response, true);
	} 	
	
	// Збереження даних в базі даних
	if (isset($data['data'])) {
		foreach ($data['data'] as $skill) {
			$id = $conn->real_escape_string($skill['id']);
			$name = $conn->real_escape_string($skill['name']);

			$query = "INSERT INTO `skills` (`id`, `name`) VALUES ('$id', '$name')";
			$result = $conn->query($query);
			
			$skills_array[] = array(
							'id'=>$id, 
							'name'=>$name
						);
		}
	}
}	

?>