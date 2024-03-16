<?php require_once 'includes/header.php'; ?>
<div id="res" class="alert alert-success" role="alert"></div>
<main class="custom-main">
<div class="container up-form">
    <form id="uploadF" enctype="multipart/form-data">
        <h2 class="text-center mb-4">File Upload</h2>
        <div class="form-group">
            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
        </div><br>
        <div class="row justify-content-center">
            <div class="col-auto" style="width: 33.33%;">
                <button type="button" class="btn btn-primary btn-block" id="upBtn">Import</button>
            </div>
            <div class="col-auto" style="width: 33.33%;">
                <button type="button" class="btn btn-secondary btn-block" id="rstBtn">Reset</button>
            </div>
            <div class="col-auto" style="width: 33.33%;">
            <a href="class_details.php" class="btn btn-danger btn-block">Return</a>
            </div>
        </div>
        <br>
        <div id="prog">
            <div id="prog-bar"></div>
        </div>
    </form>
</div>
    </main>
    <?php require_once 'includes/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#upBtn').click(function () {
            startUpload();
        });
        $('#rstBtn').click(function () {
            $('#uploadF')[0].reset();
        });
    });

    function startUpload() {
        $('#prog').show();

        var progressBar = $('#prog-bar');
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
        $('#prog').hide();
        var formData = new FormData($('#uploadF')[0]);
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
        var resultDiv = $('#res');
        resultDiv.text(message);
        resultDiv.show();
        setTimeout(function () {
            resultDiv.hide();
        }, 3000);
    }
</script>
