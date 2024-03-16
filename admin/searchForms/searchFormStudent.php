<html>
<head>
<title>Search Students</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 20px;
    }
    .search-container {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .search-container h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        color: #888;
    }
    .close:hover {
        color: #000;
    }
    .search-input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }
    .search-select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }
    .search-button {
    	padding: 10px;
    	background-color: #007bff;
    	border: none;
    	border-radius: 5px;
    	color: #fff;
    	font-size: 16px;
    	cursor: pointer;
    	margin: 0 auto;
    	display: block;
    }
    .search-button:hover {
        background-color: #0056b3;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="search-container">
    <form id="searchFromStudent">
    <span class="close">&times;</span>
    <h2>Search Students</h2>
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1; margin-right: 10px;">
                <input type="text" class="search-input" id="searchId" placeholder="Search by ID">
            </div>
            <div style="flex: 1; margin-right: 10px;">
                <input type="text" class="search-input" id="searchName" placeholder="Search by Name">
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1; margin-right: 10px;">
    		<select class="search-input" id="age" name="age">
		<?php
		include("../db.php");
		$age_sql = "SELECT * FROM age_groups";
		$age_result = $conn->query($age_sql);
		echo "<option value=''>Search by Age</option>";
		if ($age_result->num_rows > 0) {
    			while ($age_row = $age_result->fetch_assoc()) {
        		echo "<option value='" . $age_row['age_group_id'] . "'>" . $age_row['age_group_name'] . "</option>";
    			}
		}
		?>
    		</select><br>
            </div>
            <div style="flex: 1; margin-right: 10px;">
    		<select class="search-input" id="course" name="course">
		<?php
		include("../db.php");
		$course_sql = "SELECT * FROM courses";
		$course_result = $conn->query($course_sql);
		echo "<option value=''>Search by Course</option>";
		if ($course_result->num_rows > 0) {
    			while ($course_row = $course_result->fetch_assoc()) {
        		echo "<option value='" . $course_row['course_id'] . "'>" . $course_row['course_name'] . "</option>";
    			}
		}
		?>
    		</select><br>
            </div>
            <div style="flex: 1; margin-right: 10px;">
    		<select class="search-input" id="level" name="level">
		<?php
		include("../db.php");
		$level_sql = "SELECT * FROM levels";
		$level_result = $conn->query($level_sql);
		echo "<option value=''>Search by Level</option>";
		if ($course_result->num_rows > 0) {
    			while ($level_row = $level_result->fetch_assoc()) {
        		echo "<option value='" . $level_row['level_id'] . "'>" . $level_row['level_name'] . "</option>";
    			}
		}
		?>
    		</select><br>
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1; margin-right: 10px;">
                <select class="search-input" id="country" name="country" onChange="fetchStates_search();">
                    <?php
                    include("../db.php");
                    $country_sql = "SELECT * FROM countries";
                    $country_result = $conn->query($country_sql);
                    echo "<option value=''>Search by Country</option>";
                    if ($country_result->num_rows > 0) {
                        while ($country_row = $country_result->fetch_assoc()) {
                            echo "<option value='" . $country_row['country_id'] . "'>" . $country_row['country_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div style="flex: 1; margin-right: 10px;">
                <select class="search-input" id="state" name="state" onchange="fetchCities_search();">
                    <?php
                    echo "<option value='' selected>Search by State</option>";
                    ?>
                </select>
            </div>
            <div style="flex: 1; margin-right: 10px;">
                <select class="search-input" id="city" name="city">
                    <?php
                    echo "<option value='' selected>Search by City</option>";
                    ?>
                </select>
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1; margin-right: 10px;"">
                <input type="date" class="search-input" id="fromDate">
            </div>
            <div style="flex: 1; margin-right: 10px;"">
                <input type="date" class="search-input" id="toDate">
            </div>
        </div>
        <button colspan="2" type="button" class="search-button" onclick="searchStudent()">Search</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#searchId").on('input', function(){
            var idValue = $(this).val();
            if(idValue !== '') {
                $("#searchName, #age, #course, #level, #country, #state, #city, #fromDate, #toDate").prop('disabled', true);
            } else {
                $("#searchName, #age, #course, #level, #country, #state, #city, #fromDate, #toDate").prop('disabled', false);
            }
        });
        $(".close").click(function(){
            $("#searchContainer").slideUp(function(){
                $(this).html(`
                    <button type="button" class="searchButton" onclick="searchFormStudent();">Search</button>
                `).slideDown();
            });
        });
    });
</script>

</body>
</html>