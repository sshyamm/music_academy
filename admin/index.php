<!DOCTYPE html>
<html>
<head>
    <title>Music Academy</title>
    <style>
    	body {
        	background-color: #f0f0f0;
        	font-family: Arial, sans-serif;
        	text-align: center;
        	margin: 0;
        	padding: 0;
    	}
    	.button-container {
        	display: flex;
        	justify-content: center;
        	margin-top: 30px;
        	flex-wrap: wrap; /* Allow wrapping to create multiple lines */
    	}
    	.button-row {
        	display: flex;
        	justify-content: center;
        	margin-top: 10px; /* Adjust margin between rows */
    	}
    	button {
        	padding: 10px;
        	font-size: 16px;
        	margin: 10px;
    	}
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
        }
        th {
            background-color: #000;
            color: #fff;
        }
        #searchContainer {
            margin-top: 40px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .searchInput {
            padding: 10px;
            width: 40%;
            max-width: 200px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #fff;
            transition: border-color 0.3s ease;
        }
        .searchButton {
            padding: 10px;
            font-size: 16px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .searchButton:hover {
            background-color: #0056b3;
        }
        .searchInput:focus {
            outline: none;
            border-color: #007bff;
        }
	#responseMessageStudent, #responseMessageTeacher, #responseMessageTask, #responseMessageClass, #responseMessageCourse, #responseMessageLevel, #responseMessageAge, #responseMessageCity, #responseMessageState, #responseMessageCountry, #responseMessagePhase, #responseMessageInterest, #responseMessageUser, #responseMessageAssgn { height: 20px; }
    </style>
</head>
<body>
    <div id="mainContainer">
    <h1>Music Academy</h1>
    <div id="searchContainer"></div>
    <div class="button-container">
    	<div class="button-row">
        <button onclick="showStudent();">Student Manager</button>
        <button onclick="showTeacher();">Teacher Manager</button>
        <button onclick="showTask();">Task Manager</button>
        <button onclick="showClass();">Class Manager</button>
        <button onclick="showPhase();">Class sessions</button>
        <button onclick="showInterest();">Interest Manager</button>
        <button onclick="showAssgn();">Assignments</button>
    	</div>
    	<div class="button-row">
        <button onclick="showCourse();">Course Manager</button>
        <button onclick="showLevel();">Level Manager</button>
        <button onclick="showAge();">Age-group Manager</button>
        <button onclick="showCity();">City Manager</button>
        <button onclick="showState();">State Manager</button>
        <button onclick="showCountry();">Country Manager</button>
        <button onclick="showUser();">User Manager</button>
    	</div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
	function selectFile() {
    		$.ajax({
        		url: 'getForms/importStudents.php',
        		method: 'POST',
        		success: function(response) {
            		$('#mainContainer').html(response);
        		},
    		});
	}
	function fetchStates() {
    		var country_parent_id = $('#country_parent_id').val();
    		$.ajax({
        		url: 'getForms/get_states.php',
        		method: 'POST',
        		data: { country_parent_id: country_parent_id },
        		success: function(response) {
            		$('#state_parent_id').html(response);
        		},
    		});
	}
    function fetchDates_task() {
    		var course_parent_id = $('#course_parent_id').val();
    		$.ajax({
        		url: 'getForms/get_dates.php',
        		method: 'POST',
        		data: { course_parent_id: course_parent_id },
        		success: function(response) {
            		$('#date_parent_id').html(response);
        		},
    		});
	}
	function fetchStates_search() {
    		var country = $('#country').val();
    		$.ajax({
        		url: 'searchForms/get_states_search.php',
        		method: 'POST',
        		data: { country: country },
        		success: function(response) {
            		$('#state').html(response);
        		},
    		});
	}
	function fetchCities() {
    		var state_parent_id = $('#state_parent_id').val();
   			$.ajax({
        		url: 'getForms/get_cities.php',
        		method: 'POST',
        		data: { state_parent_id: state_parent_id },
        		success: function(response) {
            		$('#city_parent_id').html(response);
        		},
    		});
	}
	function fetchCities_search() {
    		var state = $('#state').val();
   			$.ajax({
        		url: 'searchForms/get_cities_search.php',
        		method: 'POST',
        		data: { state: state },
        		success: function(response) {
            		$('#city').html(response);
        		},
    		});
	}
	function fetchTeachers() {
    		var course_parent_id = $('#course_parent_id').val();
    		$.ajax({
        		url: 'getForms/get_teachers.php',
        		method: 'POST',
        		data: { course_parent_id: course_parent_id },
        		success: function(response) {
            		$('#user_parent_id').html(response);
        		},
    		});
	}
        function showStudent(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Student Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<button type="button" class="searchButton" onclick="searchFormStudent();">Search</button>
			`; 
                }
            };
            xmlhttp.open("GET", "indexes/student_index.php", true); 
            xmlhttp.send();
        }
	function searchFormStudent() {
    		$('#searchContainer').slideUp('fast', function() {
        		$.ajax({
            			url: 'searchForms/searchFormStudent.php',
            			method: 'POST',
            			success: function(response) {
                		$('#searchContainer').html(response).slideDown('slow');
            			},
        		});
    		});
	}
        function searchStudent() {
            var searchId = document.getElementById('searchId').value;
	    var searchName = document.getElementById('searchName').value;
	    var country = document.getElementById('country').value;
	    var age = document.getElementById('age').value;
	    var course = document.getElementById('course').value;
	    var level = document.getElementById('level').value;
	    var state = document.getElementById('state').value;
	    var city = document.getElementById('city').value;
	    var fromDate = document.getElementById('fromDate').value;
	    var toDate = document.getElementById('toDate').value;
            $.ajax({
                url: 'indexes/student_index.php', 
                method: 'POST',
                data: { searchId: searchId, searchName: searchName, age:age, course:course, level:level, country:country, state:state, city:city, fromDate, toDate },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showTeacher(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Teacher Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchName" class="searchInput" placeholder="Search by Name">
			<button type="button" class="searchButton" onclick="searchTeacher()">Search</button>
			`;   
                }
            };
            xmlhttp.open("GET", "indexes/teacher_index.php", true); 
            xmlhttp.send();
        }
        function searchTeacher() {
	    var searchName = document.getElementById('searchName').value;
            $.ajax({
                url: 'indexes/teacher_index.php', 
                method: 'POST',
                data: { searchName: searchName },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showTask(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Task Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchName" class="searchInput" placeholder="Search by Title">
			<button type="button" class="searchButton" onclick="searchTask()">Search</button>
			`;  
                }
            };
            xmlhttp.open("GET", "indexes/task_index.php", true); 
            xmlhttp.send();
        }
        function searchTask() {
	    var searchName = document.getElementById('searchName').value;
            $.ajax({
                url: 'indexes/task_index.php', 
                method: 'POST',
                data: { searchName: searchName },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showClass(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Class Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchCourse" class="searchInput" placeholder="Search by Course">
			<input type="text" id="searchTeacher" class="searchInput" placeholder="Search by Teacher">
			<button type="button" class="searchButton" onclick="searchClass()">Search</button>
			`;   
                }
            };
            xmlhttp.open("GET", "indexes/class_index.php", true); 
            xmlhttp.send();
        }
        function searchClass() {
            var searchCourse = document.getElementById('searchCourse').value;
	    var searchTeacher = document.getElementById('searchTeacher').value;
            $.ajax({
                url: 'indexes/class_index.php', 
                method: 'POST',
                data: { searchCourse: searchCourse, searchTeacher: searchTeacher },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showPhase(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Class Rooms</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `<marquee>Class Hours</marquee>`;   
                }
            };
            xmlhttp.open("GET", "indexes/phase_index.php", true); 
            xmlhttp.send();
        }
        function showAssgn(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Tasks in a Class</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `<marquee>Class Assignments</marquee>`;   
                }
            };
            xmlhttp.open("GET", "indexes/assgn_index.php", true); 
            xmlhttp.send();
        }
        function showCourse() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Course Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchCourse" class="searchInput" placeholder="Search by Course">
			<button type="button" class="searchButton" onclick="searchCourse()">Search</button>
			`;  
                }
            };
            xmlhttp.open("GET", "indexes/course_index.php", true); 
            xmlhttp.send();
        }
        function searchCourse() {
            var searchCourse = document.getElementById('searchCourse').value;
            $.ajax({
                url: 'indexes/course_index.php', 
                method: 'POST',
                data: { searchCourse: searchCourse },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showLevel(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Level Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchLevel" class="searchInput" placeholder="Search by Level">
			<button type="button" class="searchButton" onclick="searchLevel()">Search</button>
			`;   
                }
            };
            xmlhttp.open("GET", "indexes/level_index.php", true); 
            xmlhttp.send();
        }
        function searchLevel() {
            var searchLevel = document.getElementById('searchLevel').value;
            $.ajax({
                url: 'indexes/level_index.php', 
                method: 'POST',
                data: { searchLevel: searchLevel },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showUser(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>User Manager</h2><button onclick='returnToIndex()'>Return</button>";  
                }
            };
            xmlhttp.open("GET", "indexes/user_index.php", true); 
            xmlhttp.send();
        }
        function showInterest(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Interest Manager</h2><button onclick='returnToIndex()'>Return</button>";  
                }
            };
            xmlhttp.open("GET", "indexes/interest_index.php", true); 
            xmlhttp.send();
        }
        function showAge(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Age-group Manager</h2><button onclick='returnToIndex()'>Return</button>";  
                }
            };
            xmlhttp.open("GET", "indexes/age_index.php", true); 
            xmlhttp.send();
        }
        function showCity(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>City Manager</h2><button onclick='returnToIndex()'>Return</button>";
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchCity" class="searchInput" placeholder="Search by City">
			<button type="button" class="searchButton" onclick="searchCity()">Search</button>
			`;   
                }
            };
            xmlhttp.open("GET", "indexes/city_index.php", true); 
            xmlhttp.send();
        }
        function searchCity() {
            var searchCity = document.getElementById('searchCity').value;
            $.ajax({
                url: 'indexes/city_index.php', 
                method: 'POST',
                data: { searchCity: searchCity },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showState(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>State Manager</h2><button onclick='returnToIndex()'>Return</button>";  
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchState" class="searchInput" placeholder="Search by State">
			<button type="button" class="searchButton" onclick="searchState()">Search</button>
			`; 
                }
            };
            xmlhttp.open("GET", "indexes/state_index.php", true); 
            xmlhttp.send();
        }
        function searchState() {
            var searchState = document.getElementById('searchState').value;
            $.ajax({
                url: 'indexes/state_index.php', 
                method: 'POST',
                data: { searchState: searchState },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function showCountry(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("selectContainer").innerHTML = this.responseText;
                    document.querySelector(".button-container").innerHTML = "<h2>Country Manager</h2><button onclick='returnToIndex()'>Return</button>"; 
                    document.getElementById("searchContainer").innerHTML = `
			<input type="text" id="searchCountry" class="searchInput" placeholder="Search by Country">
			<button type="button" class="searchButton" onclick="searchCountry()">Search</button>
			`;  
                }
            };
            xmlhttp.open("GET", "indexes/country_index.php", true); 
            xmlhttp.send();
        }
        function searchCountry() {
            var searchCountry = document.getElementById('searchCountry').value;
            $.ajax({
                url: 'indexes/country_index.php', 
                method: 'POST',
                data: { searchCountry: searchCountry },
                success: function(response) {
                    $('#selectContainer').html(response); 
                },
            });
        }
        function returnToIndex() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("mainContainer").innerHTML = this.responseText;                    
                }
            };
            xmlhttp.open("GET", "index.php", true); 
            xmlhttp.send();
        }
        function showFormStudent(actionStudent, student_id) {
            if (actionStudent == 'delete_mode_student') {
                if (confirm('Are you sure you want to delete this student?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageStudent').innerHTML = response.message;
                            if (response.success) {
                                updateTableStudent();
                                setTimeout(function () {
                                    document.getElementById('responseMessageStudent').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionStudent', actionStudent);
                    formData.append('student_id', student_id);
                    xmlhttp.open("POST", "getForms/getformStudent.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerStudent").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formStudent.php?actionStudent=" + actionStudent + "&student_id=" + student_id, true);
                xmlhttp.send();
            }
        }
        function showFormTeacher(actionTeacher, teacher_id) {
            if (actionTeacher == 'delete_mode_teacher') {
                if (confirm('Are you sure you want to delete this teacher?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageTeacher').innerHTML = response.message;
                            if (response.success) {
                                updateTableTeacher();
                                setTimeout(function () {
                                    document.getElementById('responseMessageTeacher').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionTeacher', actionTeacher);
                    formData.append('teacher_id', teacher_id);
                    xmlhttp.open("POST", "getForms/getformTeacher.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerTeacher").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formTeacher.php?actionTeacher=" + actionTeacher + "&teacher_id=" + teacher_id, true);
                xmlhttp.send();
            }
        }
        function showFormTask(actionTask, task_id) {
            if (actionTask == 'delete_mode_task') {
                if (confirm('Are you sure you want to delete this task?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageTask').innerHTML = response.message;
                            if (response.success) {
                                updateTableTask();
                                setTimeout(function () {
                                    document.getElementById('responseMessageTask').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionTask', actionTask);
                    formData.append('task_id', task_id);
                    xmlhttp.open("POST", "getForms/getformTask.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerTask").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formTask.php?actionTask=" + actionTask + "&task_id=" + task_id, true); 
                xmlhttp.send();
            }
        }
        function showFormUser(actionUser, user_id) {
            if (actionUser == 'delete_mode_user') {
                if (confirm('Are you sure you want to delete this user?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageUser').innerHTML = response.message;
                            if (response.success) {
                                updateTableUser();
                                setTimeout(function () {
                                    document.getElementById('responseMessageUser').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionUser', actionUser);
                    formData.append('user_id', user_id);
                    xmlhttp.open("POST", "getForms/getformUser.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerUser").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formUser.php?actionUser=" + actionUser + "&user_id=" + user_id, true); 
                xmlhttp.send();
            }
        }
        function showFormClass(actionClass, class_id) {
            if (actionClass == 'delete_mode_class') {
                if (confirm('Are you sure you want to delete this class?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageClass').innerHTML = response.message;
                            if (response.success) {
                                updateTableClass();
                                setTimeout(function () {
                                    document.getElementById('responseMessageClass').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionClass', actionClass);
                    formData.append('class_id', class_id);
                    xmlhttp.open("POST", "getForms/getformClass.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerClass").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formClass.php?actionClass=" + actionClass + "&class_id=" + class_id, true); 
                xmlhttp.send();
            }
        }
        function showFormPhase(actionPhase, class_room_id) {
            if (actionPhase == 'delete_mode_phase') {
                if (confirm('Are you sure you want to delete this room?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessagePhase').innerHTML = response.message;
                            if (response.success) {
                                updateTablePhase();
                                setTimeout(function () {
                                    document.getElementById('responseMessagePhase').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionPhase', actionPhase);
                    formData.append('class_room_id', class_room_id);
                    xmlhttp.open("POST", "getForms/getFormPhase.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerPhase").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formPhase.php?actionPhase=" + actionPhase + "&class_room_id=" + class_room_id, true); 
                xmlhttp.send();
            }
        }
        function showFormCourse(actionCourse, course_id) {
            if (actionCourse == 'delete_mode_course') {
                if (confirm('Are you sure you want to delete this course?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageCourse').innerHTML = response.message;
                            if (response.success) {
                                updateTableCourse();
                                setTimeout(function () {
                                    document.getElementById('responseMessageCourse').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionCourse', actionCourse);
                    formData.append('course_id', course_id);
                    xmlhttp.open("POST", "getForms/getformCourse.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerCourse").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formCourse.php?actionCourse=" + actionCourse + "&course_id=" + course_id, true); 
                xmlhttp.send();
            }
        }
        function showFormLevel(actionLevel, level_id) {
            if (actionLevel == 'delete_mode_level') {
                if (confirm('Are you sure you want to delete this level?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageLevel').innerHTML = response.message;
                            if (response.success) {
                                updateTableLevel();
                                setTimeout(function () {
                                    document.getElementById('responseMessageLevel').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionLevel', actionLevel);
                    formData.append('level_id', level_id);
                    xmlhttp.open("POST", "getForms/getformLevel.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerLevel").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formLevel.php?actionLevel=" + actionLevel + "&level_id=" + level_id, true);
                xmlhttp.send();
            }
        }
        function showFormAge(actionAge, age_group_id) {
            if (actionAge == 'delete_mode_age') {
                if (confirm('Are you sure you want to delete this age-group?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageAge').innerHTML = response.message;
                            if (response.success) {
                                updateTableAge();
                                setTimeout(function () {
                                    document.getElementById('responseMessageAge').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionAge', actionAge);
                    formData.append('age_group_id', age_group_id);
                    xmlhttp.open("POST", "getForms/getformAge.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerAge").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formAge.php?actionAge=" + actionAge + "&age_group_id=" + age_group_id, true); 
                xmlhttp.send();
            }
        }
        function showFormInterest(actionInt, interest_id) {
            if (actionInt == 'delete_mode_int') {
                if (confirm('Are you sure you want to delete this interest?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageInterest').innerHTML = response.message;
                            if (response.success) {
                                updateTableInterest();
                                setTimeout(function () {
                                    document.getElementById('responseMessageInterest').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionInt', actionInt);
                    formData.append('interest_id', interest_id);
                    xmlhttp.open("POST", "getForms/getformInterest.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerInterest").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formInterest.php?actionInt=" + actionInt + "&interest_id=" + interest_id, true); 
                xmlhttp.send();
            }
        }
        function showFormAssgn(actionAssgn, task_id) {
            if (actionAssgn == 'delete_mode_assgn') {
                if (confirm('Are you sure you want to delete this task?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageAssgn').innerHTML = response.message;
                            if (response.success) {
                                updateTableAssgn();
                                setTimeout(function () {
                                    document.getElementById('responseMessageAssgn').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionAssgn', actionAssgn);
                    formData.append('task_id', task_id);
                    xmlhttp.open("POST", "getForms/getformAssgn.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerAssgn").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formAssgn.php?actionAssgn=" + actionAssgn + "&task_id=" + task_id, true); 
                xmlhttp.send();
            }
        }
        function showFormCity(actionCity, city_id) {
            if (actionCity == 'delete_mode_city') {
                if (confirm('Are you sure you want to delete this city?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageCity').innerHTML = response.message;
                            if (response.success) {
                                updateTableCity();
                                setTimeout(function () {
                                    document.getElementById('responseMessageCity').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionCity', actionCity);
                    formData.append('city_id', city_id);
                    xmlhttp.open("POST", "getForms/getformCity.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerCity").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formCity.php?actionCity=" + actionCity + "&city_id=" + city_id, true);
                xmlhttp.send();
            }
        }
        function showFormState(actionState, state_id) {
            if (actionState == 'delete_mode_state') {
                if (confirm('Are you sure you want to delete this state?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageState').innerHTML = response.message;
                            if (response.success) {
                                updateTableState();
                                setTimeout(function () {
                                    document.getElementById('responseMessageState').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionState', actionState);
                    formData.append('state_id', state_id);
                    xmlhttp.open("POST", "getForms/getformState.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerState").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formState.php?actionState=" + actionState + "&state_id=" + state_id, true);
                xmlhttp.send();
            }
        }
        function showFormCountry(actionCountry, country_id) {
            if (actionCountry == 'delete_mode_country') {
                if (confirm('Are you sure you want to delete this country?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            document.getElementById('responseMessageCountry').innerHTML = response.message;
                            if (response.success) {
                                updateTableCountry();
                                setTimeout(function () {
                                    document.getElementById('responseMessageCountry').innerHTML = "";
                                }, 3000);
                            }
                        }
                    };

                    var formData = new FormData();
                    formData.append('actionCountry', actionCountry);
                    formData.append('country_id', country_id);
                    xmlhttp.open("POST", "getForms/getformCountry.php", true); 
                    xmlhttp.send(formData);
                }
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formContainerCountry").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "forms/formCountry.php?actionCountry=" + actionCountry + "&country_id=" + country_id, true);
                xmlhttp.send();
            }
        }
        function validateFormStudent() {
            var user_parent_id = document.getElementById("user_parent_id").value;
            var phone_num = document.getElementById("phone_num").value;
            var email = document.getElementById("email").value;
            var age_group_parent_id = document.getElementById("age_group_parent_id").value;
            var course_parent_id = document.getElementById("course_parent_id").value;
            var level_parent_id = document.getElementById("level_parent_id").value;
            var emergency_contact = document.getElementById("emergency_contact").value;
            var blood_group = document.getElementById("blood_group").value;
            var address = document.getElementById("address").value;
            var pincode = document.getElementById("pincode").value;
            var city_parent_id = document.getElementById("city_parent_id").value;
            var state_parent_id = document.getElementById("state_parent_id").value;
            var country_parent_id = document.getElementById("country_parent_id").value;
            var student_status = document.getElementById("student_status").value;
            
            var alertMessage = "";

            if (user_parent_id === "") {
                alertMessage += "Please select any student.\n";
            }
            if (phone_num === "") {
                alertMessage += "Please enter the phone number.\n";
            }
            if (email === "") {
                alertMessage += "Please enter an email.\n";
            }
            if (age_group_parent_id === "") {
                alertMessage += "Please select an age.\n";
            }
            if (course_parent_id === "") {
                alertMessage += "Please select a course.\n";
            }
            if (level_parent_id === "") {
                alertMessage += "Please select a level.\n";
            }
            if (emergency_contact === "") {
                alertMessage += "Please enter emergency contact.\n";
            }
            if (blood_group === "Select Blood Group") {
                alertMessage += "Please select blood group.\n";
            }
            if (address === "") {
                alertMessage += "Please enter address.\n";
            }
            if (pincode === "") {
                alertMessage += "Please enter pincode.\n";
            }
            if (city_parent_id === "") {
                alertMessage += "Please select a city.\n";
            }
            if (state_parent_id === "") {
                alertMessage += "Please select a state.\n";
            }
            if (country_parent_id === "") {
                alertMessage += "Please select a country.\n";
            }
            if (student_status === "Select") {
                alertMessage += "Please select any student status.\n";
            }
            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormStudent"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageStudent').innerHTML = response.message;
                        if (response.success) {
                            updateTableStudent();
                            document.getElementById('formStudentContainer').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageStudent').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformStudent.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormTeacher() {
    		var user_parent_id = document.getElementById("user_parent_id").value;
    		var teacher_phone = document.getElementById("teacher_phone").value;
    		var teacher_email = document.getElementById("teacher_email").value;
    		var teacher_address = document.getElementById("teacher_address").value;
    		var course_parent_id = document.getElementById("course_parent_id").value;
    		var qualification = document.getElementById("qualification").value;
   	 	var teacher_exp = document.getElementById("teacher_exp").value;
    		var contract_date = document.getElementById("contract_date").value;
    		var current_salary = document.getElementById("current_salary").value;
    		var join_date = document.getElementById("join_date").value;
    		var teacher_status = document.getElementById("teacher_status").value;

    		var alertMessage = "";

    		if (user_parent_id === "") {
        		alertMessage += "Please select a Teacher name.\n";
    		}
    		if (teacher_phone === "") {
        		alertMessage += "Please enter a teacher phone number.\n";
    		}
    		if (teacher_email === "") {
        		alertMessage += "Please enter a teacher email.\n";
    		}
    		if (teacher_address === "") {
        		alertMessage += "Please enter a teacher address.\n";
    		}
    		if (course_parent_id === "Select Course") {
        		alertMessage += "Please select course.\n";
    		}
    		if (qualification === "") {
        		alertMessage += "Please enter qualification.\n";
    		}
    		if (teacher_exp === "") {
        		alertMessage += "Please enter teacher experience.\n";
    		}
    		if (contract_date === "") {
        		alertMessage += "Please select contract date.\n";
    		}
    		if (current_salary === "") {
        		alertMessage += "Please enter current salary.\n";
    		}
    		if (join_date === "") {
        		alertMessage += "Please select joined date.\n";
    		}
    		if (teacher_status === "Select") {
        		alertMessage += "Please select a teacher status.\n";
    		}
    		if (alertMessage !== "") {
        		alert(alertMessage);
        		return;
    		} else {
        		var xmlhttp = new XMLHttpRequest();
        		var formData = new FormData(document.getElementById("createProductFormTeacher"));

        		xmlhttp.onreadystatechange = function () {
            		if (this.readyState == 4 && this.status == 200) {
                		var response = JSON.parse(this.responseText);
                		document.getElementById('responseMessageTeacher').innerHTML = response.message;
                		if (response.success) {
                    			updateTableTeacher();
                    			document.getElementById('createProductFormTeacher').style.display = 'none';
                    			setTimeout(function () {
                        		document.getElementById('responseMessageTeacher').innerHTML = "";
                    		}, 3000);
                	        }
            		}
        		};
        		xmlhttp.open("POST", "getForms/getformTeacher.php", true); 
        		xmlhttp.send(formData);
    			}
		}
        function validateFormClass() {
            var course_parent_id = document.getElementById("course_parent_id").value;
            var user_parent_id = document.getElementById("user_parent_id").value;
            var start_time = document.getElementById("start_time").value;
            var end_time = document.getElementById("end_time").value;
            var date_of_class = document.getElementById("date_of_class").value;
            var class_status = document.getElementById("class_status").value;
            
            var alertMessage = "";

            if (course_parent_id === "") {
                alertMessage += "Please select course.\n";
            }
            if (user_parent_id === "") {
                alertMessage += "Please select teacher.\n";
            }
            if (start_time === "") {
                alertMessage += "Please select start time.\n";
            }
            if (end_time === "") {
                alertMessage += "Please select end time.\n";
            }
            if (date_of_class === "") {
                alertMessage += "Please select a day.\n";
            }
            if (class_status === "Select") {
                alertMessage += "Please select any slot status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormClass"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageClass').innerHTML = response.message;
                        if (response.success) {
                            updateTableClass();
                            document.getElementById('createProductFormClass').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageClass').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformClass.php", true);
                xmlhttp.send(formData);
            }
        }
        function validateFormPhase() {
            var class_parent_id = document.getElementById("class_parent_id").value;
            var user_parent_id = document.getElementById("user_parent_id").value;
            var attendance = document.getElementById("attendance").value;
            var class_room_status = document.getElementById("class_room_status").value;
            
            var alertMessage = "";

            if (class_parent_id === "") {
                alertMessage += "Please select class.\n";
            }
            if (user_parent_id === "") {
                alertMessage += "Please select student.\n";
            }
            if (attendance === "Select") {
                alertMessage += "Please select attendance.\n";
            }
            if (class_room_status === "Select") {
                alertMessage += "Please select any room status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormPhase"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessagePhase').innerHTML = response.message;
                        if (response.success) {
                            updateTablePhase();
                            document.getElementById('createProductFormPhase').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessagePhase').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getFormPhase.php", true);
                xmlhttp.send(formData);
            }
        }
        function validateFormTask() {
            var task_title = document.getElementById("task_title").value;
            var task_desc = document.getElementById("task_desc").value;
            var assigned_to = document.getElementById("assigned_to").value;
            var assigned_by = document.getElementById("assigned_by").value;
            var deadline = document.getElementById("deadline").value;
            var priority = document.getElementById("priority").value;
            var estimated_hours = document.getElementById("estimated_hours").value;
            var file_path = document.getElementById("file_path");
            var task_status = document.getElementById("task_status").value;
            
            var alertMessage = "";

            if (task_title === "") {
                alertMessage += "Please enter a task title.\n";
            }
            if (task_desc === "") {
                alertMessage += "Please enter the description.\n";
            }
            if (assigned_to === "") {
                alertMessage += "Please select the assigned student.\n";
            }
            if (assigned_by === "") {
                alertMessage += "Please select the assigned teacher.\n";
            }
            if (deadline === "") {
                alertMessage += "Please select a deadline.\n";
            }
            if (priority === "") {
                alertMessage += "Please select the priority.\n";
            }
            if (estimated_hours === "") {
                alertMessage += "Please enter estimated hours.\n";
            }
            if (task_status === "Select") {
                alertMessage += "Please select any task status.\n";
            }
            if (task_status === "Completed" && file_path.files.length === 0) {
                alertMessage += "File attachment is required for completed tasks.\n";
            }
            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormTask"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageTask').innerHTML = response.message;
                        if (response.success) {
                            updateTableTask();
                            document.getElementById('createProductFormTask').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageTask').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformTask.php", true);
                xmlhttp.send(formData);
            }
        }
        function validateFormCourse() {
            var course_name = document.getElementById("course_name").value;
            var course_desc = document.getElementById("course_desc").value;
            var course_status = document.getElementById("course_status").value;
            
            var alertMessage = "";

            if (course_name === "") {
                alertMessage += "Please enter a course name.\n";
            }
            if (course_desc === "") {
                alertMessage += "Please enter the description.\n";
            }
            if (course_status === "Select") {
                alertMessage += "Please select any course status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormCourse"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageCourse').innerHTML = response.message;
                        if (response.success) {
                            updateTableCourse();
                            document.getElementById('createProductFormCourse').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageCourse').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformCourse.php", true);
                xmlhttp.send(formData);
            }
        }
        function validateFormLevel() {
            var level_name = document.getElementById("level_name").value;
            var level_status = document.getElementById("level_status").value;
            
            var alertMessage = "";

            if (level_name === "") {
                alertMessage += "Please enter a level name.\n";
            }
            if (level_status === "Select") {
                alertMessage += "Please select any level status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormLevel"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageLevel').innerHTML = response.message;
                        if (response.success) {
                            updateTableLevel();
                            document.getElementById('createProductFormLevel').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageLevel').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformLevel.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormUser() {
            var user_name = document.getElementById("user_name").value;
            var user_password = document.getElementById("user_password").value;
            var user_type = document.getElementById("user_type").value;
            var user_status = document.getElementById("user_status").value;
            
            var alertMessage = "";

            if (user_name === "") {
                alertMessage += "Please enter a user name.\n";
            }
            if (user_password === "") {
                alertMessage += "Please enter user password.\n";
            }
            if (user_type === "Select") {
                alertMessage += "Please select any user type.\n";
            }
            if (user_status === "Select") {
                alertMessage += "Please select any user status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormUser"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageUser').innerHTML = response.message;
                        if (response.success) {
                            updateTableUser();
                            document.getElementById('createProductFormUser').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageUser').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformUser.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormInterest() {
            var user_parent_id = document.getElementById("user_parent_id").value;
            var course_parent_id = document.getElementById("course_parent_id").value;
            var level_parent_id = document.getElementById("level_parent_id").value;
            var interest_status = document.getElementById("interest_status").value;
            
            var alertMessage = "";

            if (user_parent_id === "") {
                alertMessage += "Please select any student.\n";
            }
            if (course_parent_id === "Select Course") {
                alertMessage += "Please select any course.\n";
            }
            if (level_parent_id === "Select Level") {
                alertMessage += "Please select any level.\n";
            }
            if (interest_status === "Select") {
                alertMessage += "Please select any interest status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormInterest"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageInterest').innerHTML = response.message;
                        if (response.success) {
                            updateTableInterest();
                            document.getElementById('createProductFormInterest').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageInterest').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformInterest.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormAssgn() {
            var task_desc = document.getElementById("task_desc").value;
            var course_parent_id = document.getElementById("course_parent_id").value;
            var date_parent_id = document.getElementById("date_parent_id").value;
            var task_status = document.getElementById("task_status").value;
            
            var alertMessage = "";

            if (task_desc === "") {
                alertMessage += "Please enter task description.\n";
            }
            if (course_parent_id === "") {
                alertMessage += "Please select any course.\n";
            }
            if (date_parent_id === "") {
                alertMessage += "Please select any date.\n";
            }
            if (task_status === "Select") {
                alertMessage += "Please select any task status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormAssgn"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageAssgn').innerHTML = response.message;
                        if (response.success) {
                            updateTableAssgn();
                            document.getElementById('createProductFormAssgn').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageAssgn').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformAssgn.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormAge() {
            var age_group_name = document.querySelector('input[name="age_group_name"]:checked');
            var age_group_status = document.getElementById("age_group_status").value;

            var alertMessage = "";

            if (!age_group_name) {
                alertMessage += "Please select an age group.\n";
            }
            if (age_group_status === "Select") {
                alertMessage += "Please select any age status.\n";
            }
            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormAge"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageAge').innerHTML = response.message;
                        if (response.success) {
                            updateTableAge();
                            document.getElementById('createProductFormAge').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageAge').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformAge.php", true);
                xmlhttp.send(formData);
            }
        }
        function validateFormCity() {
            var state_parent_id = document.getElementById("state_parent_id").value;
            var city_name = document.getElementById("city_name").value;
            var city_status = document.getElementById("city_status").value;
            
            var alertMessage = "";

            if (state_parent_id === "") {
                alertMessage += "Please select state.\n";
            }
            if (city_name === "") {
                alertMessage += "Please enter a city name.\n";
            }
            if (city_status === "Select") {
                alertMessage += "Please select any city status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormCity"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageCity').innerHTML = response.message;
                        if (response.success) {
                            updateTableCity();
                            document.getElementById('createProductFormCity').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageCity').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformCity.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormState() {
	    var country_parent_id = document.getElementById("country_parent_id").value;
            var state_name = document.getElementById("state_name").value;
            var state_status = document.getElementById("state_status").value;
            
            var alertMessage = "";

            if (country_parent_id === "") {
                alertMessage += "Please select any country.\n";
            }
            if (state_name === "") {
                alertMessage += "Please enter a state name.\n";
            }
            if (state_status === "Select") {
                alertMessage += "Please select any state status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormState"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageState').innerHTML = response.message;
                        if (response.success) {
                            updateTableState();
                            document.getElementById('createProductFormState').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageState').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformState.php", true); 
                xmlhttp.send(formData);
            }
        }
        function validateFormCountry() {
            var country_name = document.getElementById("country_name").value;
            var country_status = document.getElementById("country_status").value;
            
            var alertMessage = "";

            if (country_name === "") {
                alertMessage += "Please enter a country name.\n";
            }
            if (country_status === "Select") {
                alertMessage += "Please select any country status.\n";
            }

            if (alertMessage !== "") {
                alert(alertMessage);
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                var formData = new FormData(document.getElementById("createProductFormCountry"));

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('responseMessageCountry').innerHTML = response.message;
                        if (response.success) {
                            updateTableCountry();
                            document.getElementById('createProductFormCountry').style.display = 'none';
                            setTimeout(function () {
                                document.getElementById('responseMessageCountry').innerHTML = "";
                            }, 3000);
                        }
                    }
                };

                xmlhttp.open("POST", "getForms/getformCountry.php", true); 
                xmlhttp.send(formData);
            }
        }
        function updateTableStudent() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerStudent").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformStudent.php", true); 
            xmlhttp.send();
        }
        function updateTableTeacher() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerTeacher").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformTeacher.php", true); 
            xmlhttp.send();
        }
        function updateTableClass() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerClass").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformClass.php", true); 
            xmlhttp.send();
        }
        function updateTablePhase() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerPhase").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformPhase.php", true); 
            xmlhttp.send();
        }
        function updateTableTask() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerTask").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformTask.php", true); 
            xmlhttp.send();
        }
        function updateTableInterest() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerInterest").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformInterest.php", true); 
            xmlhttp.send();
        }
        function updateTableAssgn() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerAssgn").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformAssgn.php", true); 
            xmlhttp.send();
        }
        function updateTableUser() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerUser").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformUser.php", true); 
            xmlhttp.send();
        }
        function updateTableCourse() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerCourse").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformCourse.php", true); 
            xmlhttp.send();
        }
        function updateTableLevel() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerLevel").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformLevel.php", true); 
            xmlhttp.send();
        }
        function updateTableAge() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerAge").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformAge.php", true); 
            xmlhttp.send();
        }
        function updateTableCity() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerCity").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformCity.php", true); 
            xmlhttp.send();
        }
        function updateTableState() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerState").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformState.php", true); 
            xmlhttp.send();
        }
        function updateTableCountry() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("updateTableContainerCountry").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateForms/updateformCountry.php", true); 
            xmlhttp.send();
        }
    </script>
    <div id="selectContainer"></div>

    <div id="formContainerStudent"></div>
    <div id="formContainerTeacher"></div>
    <div id="formContainerTask"></div>
    <div id="formContainerClass"></div>
    <div id="formContainerPhase"></div>
    <div id="formContainerCourse"></div>
    <div id="formContainerLevel"></div>
    <div id="formContainerInterest"></div>
    <div id="formContainerAssgn"></div>
    <div id="formContainerAge"></div>
    <div id="formContainerCity"></div>
    <div id="formContainerState"></div>
    <div id="formContainerCountry"></div>
</body>
</div>
</html>
