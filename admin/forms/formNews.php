<!DOCTYPE html>
<html>
<head>
    <style>
        form {
            width: 50%;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }

        input[type="text"],
        select, textarea {
            padding: 10px;
            margin: 10px;
            width: 90%;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        button[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #90EE90;
            color: black;
            border: none;
            cursor: pointer;
        }

        button[type="button"]:hover {
            background-color: #7CFC00;
        }
    </style>
</head>
<body>

<?php
$actionNews = isset($_GET['actionNews']) ? $_GET['actionNews'] : 'create_mode_news';
$email = '';
$news_status = '';

if ($actionNews == 'edit_mode_news') {
    include("../db.php");

    $news_id = isset($_GET['news_id']) ? $_GET['news_id'] : null;
    if ($news_id !== null) {
        $my_sql  = "SELECT * FROM news WHERE news_id = $news_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $email = $row["email"];
            $news_status = $row["news_status"];
        }
    }
}
?>

<form id="createProductFormNews" method="post">
    <input type="text" id="email" name="email" <?php echo $actionNews !== 'create_mode_news' ? 'value="' . $email . '"' : 'placeholder="Email"'; ?>><br>
    <select id="news_status" name="news_status">
        <option value="Select" <?php echo ($actionNews === 'create_mode_news') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionNews === 'edit_mode_news' && $news_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionNews === 'edit_mode_news' && $news_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionNews == "edit_mode_news") { ?>
        <input type="hidden" name="news_id" value="<?php echo $news_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionNews" value="<?php echo $actionNews; ?>" />

    <?php if ($actionNews == 'edit_mode_news') { ?>
        <button type="button" onclick="validateFormNews()">Update</button>
    <?php } elseif ($actionNews == 'create_mode_news') { ?>
        <button type="button" onclick="validateFormNews()">Create</button>
    <?php } ?>
</form>

</body>
</html>
