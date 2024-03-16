<html>
<head>
    <title>File Upload</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .upload-form {
            position: fixed;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
        }

        #result {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            width: 100%;
            max-width: 500px;
            text-align: center;
            margin-top: 20px;
            z-index: 1000;
        }

        #progress {
            width: 90%;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: none;
        }

        #progress-bar {
            width: 0%;
            height: 15px;
            background-color: green;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div id="result" class="alert alert-success" role="alert"></div>
<div class="container upload-form">
    <form id="uploadForm" enctype="multipart/form-data">
        <h2 class="text-center mb-4">File Upload</h2>
        <div class="form-group">
            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
        </div><br>
        <div class="row justify-content-center">
            <div class="col-auto" style="width: 50%;">
                <button type="button" class="btn btn-primary btn-block" id="uploadBtn">Import</button>
            </div>
            <div class="col-auto" style="width: 50%;">
                <button type="button" class="btn btn-secondary btn-block" id="resetBtn">Reset</button>
            </div>
        </div>
        <br>
        <div id="progress">
            <div id="progress-bar"></div>
        </div>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#uploadBtn').click(function () {
            startUpload();
        });
    });
    $('#resetBtn').click(function () {
        $('#fileToUpload').val('');
    });

    function startUpload() {
        $('#progress').show();

        var progressBar = $('#progress-bar');
        var width = 0;
        var interval = setInterval(function () {
            width += 1;
            progressBar.css('width', width + '%');
            if (width >= 100) {
                clearInterval(interval);
                proceed();
            }
        }, 15);
    }

    function proceed() {
        $('#progress').hide();
        var formData = new FormData($('#uploadForm')[0]);
        $.ajax({
            url: 'getForms/upload.php',
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
