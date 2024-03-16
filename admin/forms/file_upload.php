<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #result {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        form {
            margin-top: 80px;
            text-align: center;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="button"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="button"]:hover {
            background-color: #0056b3;
        }

	#progress {
    		display: none;
    		width: 25%;
    		position: absolute;
    		left: 50%;
    		transform: translateX(-50%);
	}
        #progress-bar {
            width: 0%;
            height: 20px;
            background-color: #007bff;
            border-radius: 4px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="result"></div>
    <form id="uploadForm" enctype="multipart/form-data">
        <h2>File Upload</h2>
        <p>Select image to upload:</p>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="button" id="uploadBtn" value="Upload Image">
    </form>
	<br/>
    <div id="progress">
        <div id="progress-bar"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('#uploadBtn').click(function () {
                startUpload();
            });
        });
        function startUpload() {
            $('#progress').show();

            var progressBar = $('#progress-bar');
            var width = 0;
            var interval = setInterval(function () {
                width += 1;
                progressBar.width(width + '%');
                if (width >= 100) {
                    clearInterval(interval);
                    proceed();
                }
            }, 20);
        }

        function proceed() {
            $('#progress').hide();

            var formData = new FormData($('#uploadForm')[0]);
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showMessage(response);
                }
            });
        }

        function showMessage(message) {
            var resultDiv = $('#result');
            resultDiv.text(message);
            resultDiv.show();
            setTimeout(function () {
                resultDiv.hide();
            }, 3000);
        }
    </script>
</body>
</html>
