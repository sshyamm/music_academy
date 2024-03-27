
<?php
require_once 'includes/config.php';


if(isset($_GET['course_id'])) {
   $course_id = $_GET['course_id'];
   $query = "SELECT c.*, u.user_name FROM courses c LEFT JOIN teachers t ON c.course_id = t.course_parent_id LEFT JOIN users u ON t.user_parent_id = u.user_id WHERE c.course_id = :course_id";
   $stmt = $db->prepare($query);
   $stmt->bindParam(':course_id', $course_id);
   $stmt->execute();
   $course = $stmt->fetch(PDO::FETCH_ASSOC);


   if($course) {
?>
<?php require_once 'includes/header.php'; ?>
<div class="jumbotron jumbotron-fluid jumbotron7">
   <div class="container">
       <h1 class="display-4"><?php echo $course['course_name']; ?></h1>
       <nav aria-label="breadcrumb">
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php">Home</a></li>
               <li class="breadcrumb-item"><a href="classes.php">Music Classes</a></li>
               <li class="breadcrumb-item active" aria-current="page"><?php echo $course['course_name']; ?></li>
           </ol>
       </nav>
   </div>
</div>


<main class="custom-main">
   <div class="container mt-5">
       <div class="row">
           <div class="col-md-6 centered-column-img">
               <img src="imgFolder/<?php echo $course['course_img']; ?>" class="img-fluid" alt="<?php echo $course['course_name']; ?>" style="max-width: 300px; height: auto;">
           </div>
           <div class="col-md-6">
               <div class="drums-description">
                   <h3>About <?php echo $course['course_name']; ?></h3>
                   <p><?php echo $course['course_desc']; ?></p>
               </div>
           </div>
       </div>
 <?php if ($_SESSION['user_type'] !== 'Teacher') { ?>
   <div class="crs-inf">
   <div class="row">
     <div class="col-md-6">
       <h2>Course Details</h2>
       <ul class="list-group">
         <li class="lst-grp-itm"><strong>Instructor:</strong> <?php echo $course['user_name']; ?></li>
         <li class="lst-grp-itm"><strong>Description:</strong> <?php echo $course['course_desc']; ?></li>
       </ul>
     </div>
     <div class="col-md-6">
       <h2>I'm Interested</h2>
	 <p>Embark on a musical journey of discovery and growth by expressing your interest in our vibrant and innovative music academy today.</p>


       <?php
       if ($_SESSION['user_type'] === 'Student') {
           $sql = "SELECT COUNT(*) AS count FROM interests WHERE user_parent_id = :user_id AND course_parent_id = :course_id";
           $stmt = $db->prepare($sql);
           $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
           $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
           $stmt->execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           if ($result['count'] > 0) {
               echo '<button type="button" class="btn btn-primary btn-lg enl-btn" disabled>Already applied</button>';
           } else {
               echo '<button type="button" class="btn btn-primary btn-lg enl-btn" id="interestedBtn">I\'m Interested</button>';
           }
       } else {
         echo '<a href="login.php"><button type="button" class="btn btn-primary btn-lg enl-btn">Login to make Interest</button></a>';
       }
       ?>
     </div>
   </div>
 </div>
 <?php } ?>
 <div class="row mt-5">
    <div class="col-md-12">
        <?php if(isset($_SESSION['user_name']) && isset($_SESSION['user_type'])){ ?>
        <div class="comment-section">
            <h3>Leave a Comment</h3>
            <form id="comment-form" method="post">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter your comment"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <?php } ?>
        <h3>Comments</h3>
        <div class="comment-section">
            <?php
            $comment_query = "SELECT u.user_name, c.comment, c.created_at FROM comments c
                            INNER JOIN users u ON c.user_parent_id = u.user_id
                            WHERE c.course_parent_id = :course_id
                            ORDER BY c.created_at DESC";
            $comment_stmt = $db->prepare($comment_query);
            $comment_stmt->bindParam(':course_id', $course_id);
            $comment_stmt->execute();
            $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($comments)) {
                foreach ($comments as $comment) {
                    echo '<div class="comment">';
                    echo '<div class="meta">' . $comment['user_name'] . ' - ' . $comment['created_at'] . '</div>';
                    echo '<div class="user-content">' . $comment['comment'] . '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No comments given';
            }
            ?>
        </div>
    </div>
</div>
</main>
<?php
   } else {
       echo "Course not found!";
   }
} else {
   echo "Course ID not provided!";
}
?>
<?php require_once 'includes/footer.php'; ?>


<script>
$(document).ready(function() {
    $('#comment-form').submit(function(event) {
    event.preventDefault();
    var commentValue = $('#comment').val().trim();

    if (commentValue === '') {
        alert('Please enter a comment.');
        return;
    }

    var formData = $(this).serialize();
    formData += '&user_id=<?php echo $_SESSION["user_id"]; ?>&course_id=<?php echo $course_id; ?>'; 

    $.ajax({
        url: 'submit_comment.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            $('.comment-section').last().prepend(response);
            $('#comment').val('');
        },
        error: function() {
            alert('An error occurred. Please try again later.');
        }
    });
});

$('#interestedBtn').on('click', function() {
    $.ajax({
        url: 'interested.php',
        type: 'POST',
        data: {
            user_id: <?php echo $_SESSION['user_id']; ?>,
            course_id: <?php echo $course_id; ?>
        },
        success: function(response) {
            if (response === 'success') {
                $('#interestedBtn').text('Already applied').prop('disabled', true);
                location.reload();
            } else {
                alert('An error occurred. Please try again later.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again later.');
        }
    });
});
});
</script>

