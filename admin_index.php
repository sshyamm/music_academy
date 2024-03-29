<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <style> 
        form {
            width: 30%;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 10px;
            margin: 10px;
            width: 90%;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #90EE90;
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 8px;
        }

        button[type="submit"]:hover {
            background-color: #7CFC00;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: left;
            margin-left: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <form id="loginForm">
        <h2>Admin Login</h2>
        <hr>
        <input type="text" id="admin_username" name="admin_username" placeholder="Admin Username" required>
        <input type="password" id="admin_password" name="admin_password" placeholder="Admin Password" required>
        <select id="adminStatus" name="adminStatus" required>
            <option value="">Select</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <button type="submit">Login</button>
    </form>

    <script>
        $(document).ready(function(){
            $('#loginForm').validate({
                rules: {
                    admin_username: {
                        required: true,
                    },
                    admin_password: {
                        required: true,
                        minlength: 4
                    },
                    adminStatus: {
                        required: true
                    }
                },
                messages: {
                    admin_username: {
                        required: "Please enter your username",
                    },
                    admin_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 4 characters long"
                    },
                    adminStatus: {
                        required: "Please select admin status"
                    }
                },
                errorClass: "error",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: 'check.php',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            alert(response);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>
</html>
