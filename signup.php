<?php require_once 'includes/header.php'; ?>
<main class="custom-main">
    <span>&nbsp;</span>
    <h2 id="signup-message">&nbsp;</h2>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card login-card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Sign Up</h5>
                        <form id="signup-form" method="post" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password"><br>
                                <div class="auth-error"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary login-btn">Sign Up</button>
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
        $('#signup-form').validate({
            rules: {
                'user_name': {
                    required: true,
                    minlength: 5,
                    maxlength: 16
                },
                'user_password': {
                    required: true,
                    minlength: 4,
                    maxlength: 12
                },
                'confirm_password': {
                    required: true,
                    equalTo: '#user_password'
                }
            },
            messages: {
                'user_name': {
                    required: "Please enter a username",
                    minlength: "Username must be 5-16 characters long"
                },
                'user_password': {
                    required: "Please enter a password",
                    minlength: "Password must be 4-12 characters long"
                },
                'confirm_password': {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                }
            },
            errorClass: "error",
            errorPlacement: function (error, element) {
                error.appendTo(element.parent().find(".auth-error"));
            },
            submitHandler: function(form) {
                $.ajax({
                    url: 'api/create_user.php',
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $('#signup-message').text(response.error);
                        } else {
                            $('#signup-message').text(response.Message);
                            form.reset();
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
