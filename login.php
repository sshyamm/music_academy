<?php require_once 'includes/header.php'; ?>
<main class="custom-main">
<span>&nbsp;</span>
<h2 id="signup-message">&nbsp;</h2>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card login-card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Login</h5>
                    <form id="login-form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="student_username">Username</label>
                            <input type="text" class="form-control" id="student_username" name="student_username" placeholder="Enter your username"><br>
                            <div class="auth-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="student_password">Password</label>
                            <input type="password" class="form-control" id="student_password" name="student_password" placeholder="Enter your password"><br>
                            <div class="auth-error"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary login-btn">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
    $(document).ready(function(){
        $('#login-form').validate({
            rules: {
                'student_username': {
                    required: true
                },
                'student_password': {
                    required: true
                }
            },
            messages: {
                'student_username': {
                    required: "Please enter a username"
                },
                'student_password': {
                    required: "Please enter a password"
                }
            },
            errorClass: "error",
            errorPlacement: function (error, element) {
                error.appendTo(element.parent().find(".auth-error"));
            },
            submitHandler: function(form) {
                $.ajax({
                    url: 'api/get_user.php',
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $('#signup-message').text(response.error);
                        } else {
                            $('#signup-message').text(response.Message);
                        }
                        setTimeout(function() {
                            $('#signup-message').text('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("An error occurred while processing your request.");
                    }
                });
                return false;
            }
        });
    });
</script>