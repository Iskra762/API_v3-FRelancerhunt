<?php

$category = '';
$category_name = '';
if (isset($_POST['category'])) {
    $category = $conn->real_escape_string((int)$_POST['category']);
}

// вибірка проєктів за обраною категорією
if ($category != '' && $category != 0) {
	$query = "SELECT * FROM `projects` WHERE `id` IN (
				SELECT `project` FROM `category` WHERE `skill`='$category'
	)";
} else {
	$query = "SELECT * FROM `projects`";
}	
$result = $conn->query($query);


$budget_groups = array(
    '<500' => 0,
    '500-1000' => 0,
    '1000-5000' => 0,
    '>5000' => 0
);


echo '<!doctype html>';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<meta http-equiv="Content-Language" content="ru" />';
echo '<meta name="Description" content="Тестове завдання" />';
echo '<title>Тестове завдання</title>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>'; 
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">';  
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">';
echo '</head>';
echo '<body>';

// відображення форми для фільтрації за категорією
echo "<form method='post'>";
echo "<label for='category'>Фільтрувати за категорією:</label>";
echo "<select id='category' name='category'>";
echo "<option value='0'>Всі категорії</option>";

foreach($skills_array as $skill) {
	$id = $skill['id'];
	$name = $skill['name'];
	if ($id == $category) {
		$category_name = $name;
		echo "<option value='$id' selected>$name</option>";		
	} else {	
		echo "<option value='$id'>$name</option>";
	}	
}

echo "</select>";
echo "<button type='submit'>Фільтрувати</button>";
echo "</form>";

// відображення списку проєктів, відфільтрованих за категорією
echo "<h2>Список проєктів за категорією '$category_name'</h2>";
echo "<table>";
echo "<tr><th>№ з/п</th><th>Назва проєкту</th><th>Бюджет</th><th>Ім'я та логін замовника</th></tr>";

$i = 0;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['budget'] < 500) {
        $budget_groups['<500']++;
    } elseif ($row['budget'] >= 500 && $row['budget'] < 1000) {
        $budget_groups['500-1000']++;
    } elseif ($row['budget'] >= 1000 && $row['budget'] < 5000) {
        $budget_groups['1000-5000']++;
    } else {
        $budget_groups['>5000']++;
    }
	$i++;
	echo "<tr>";
	echo "<td>$i</td>";
	echo "<td><a href='" . $row['link'] . "'>" . $row['name'] . "</a></td>";
	echo "<td>" . $row['budget'] . "</td>";
	echo "<td>" . $row['employer_first_name'] . ' ' . $row['employer_last_name'] . " (" . $row['employer_login'] . ")</td>";
	echo "</tr>";
}

echo "</table>";
echo '<canvas id="myChart"></canvas>';

$budget1 = $budget_groups['<500'];
$budget2 = $budget_groups['500-1000'];
$budget3 = $budget_groups['1000-5000'];
$budget4 = $budget_groups['>5000'];

echo "<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['<500', '500-1000', '1000-5000', '>5000'],
        datasets: [{
            data: [$budget1, $budget2, $budget3, $budget4],
            backgroundColor: [
                'rgba(0, 255, 255, 0.6)',  
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 255, 0, 0.6)', 
                'rgba(0, 255, 0, 0.6)' 
            ],
            borderColor: [
                'rgba(0, 0, 0, 1)',
                'rgba(0, 0, 0, 1)',
                'rgba(0, 06,0, 1)',
                'rgba(0, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                fontColor: 'rgb(255, 255, 255)', 
                fontSize: 14
            }
        },
        title: {
            display: true,
            text: 'Розподіл бюджетів проектів',
            fontSize: 18,
            fontColor: 'rgb(255, 255, 255)' 
        }
    }
});
</script>"; 

echo '</body>';
echo '</html>';
?>