<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Upload Card</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card" style="box-shadow: 0 0.8rem 3rem rgba(0, 0, 0, 0.4); border-radius: 1.5rem;">
        <div class="card-header bg-warning text-dark">
          Upload Task
        </div>
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label for="taskDescription" class="form-label">Task Description</label>
              <textarea class="form-control" id="taskDescription" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="taskFile" class="form-label">Task File</label>
              <input class="form-control" type="file" id="taskFile">
            </div>
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-primary" id="upBtn">Upload</button><span>&nbsp;</span>
              <button type="reset" class="btn btn-secondary">Reset</button><span>&nbsp;</span>
              <button type="button" class="btn btn-danger" onclick="window.history.back();">Return</button>
            </div>
            <!-- Reserve space for progress bar -->
            <div id="progressContainer" class="mt-3" style="display: none;">
              <div class="progress" style="height: 12px;">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#upBtn').click(function() {
      $('#progressContainer').css('display', 'block');
      var progress = 0;
      var interval = setInterval(function() {
        progress += 10;
        $('#progressBar').css('width', progress + '%');
        if (progress >= 100) {
          clearInterval(interval);
          setTimeout(function() {
            $('#progressContainer').hide();
            $('#progressBar').css('width', '0%');
          }, 500); 
        }
      }, 100); 
    });
  });
</script>
</body>
</html>
