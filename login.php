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
                            <label for="user_name">Username</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter your username"><br>
                            <div class="auth-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter your password"><br>
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
                'user_name': {
                    required: true
                },
                'user_password': {
                    required: true
                }
            },
            messages: {
                'user_name': {
                    required: "Please enter a username"
                },
                'user_password': {
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
                            window.location.href = 'index.php';
                        }, 900);
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