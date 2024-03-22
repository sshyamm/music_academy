<?php
require_once 'includes/config.php';


$query = "SELECT * FROM courses";
$stmt = $db->query($query);
if ($stmt) {
   $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
   echo "Error: Unable to fetch courses from the database";
   die();
}
?>


<?php require_once 'includes/header.php'; ?>
<div class="jumbotron jumbotron-fluid jumbotron1">
   <div class="container">
       <h1 class="display-4">Music Classes</h1>
       <nav aria-label="breadcrumb">
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo URL; ?>/index.php">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Music Classes</li>
           </ol>
       </nav>
   </div>
</div>

<?php if(isset($_SESSION['user_name']) && isset($_SESSION['user_id'])): ?>
       <div class="container">
           <div class="row justify-content-center mt-3">
               <div class="col-md-6">
                       <div class="card-body d-flex align-items-center justify-content-between p-1">
                           <div>
                               <h5 class="card-title m-0">Scheduled Classes</h5>
                               <p class="card-text m-0">View our upcoming classes schedule and join us!</p>
                           </div>
                           <a href="class_info.php" class="btn btn-primary">View Classes</a>
                       </div>
               </div>
           </div>
       </div>
   <?php endif; ?>
   
<main class="custom-main">
   <div class="container mt-5">
       <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
           <div class="carousel-inner">
               <?php $active = true; ?>
               <?php for ($i = 0; $i < count($courses); $i += 3): ?>
                   <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                       <div class="row">
                           <?php for ($j = $i; $j < $i + 3 && $j < count($courses); $j++): ?>
                               <div class="col-md-4 animated fadeInUp">
                                   <div class="class-card">
                                       <a href="course_details.php?course_id=<?php echo $courses[$j]['course_id']; ?>">
                                           <img src="imgFolder/<?php echo $courses[$j]['course_icon']; ?>" class="card-img-top" alt="<?php echo $courses[$j]['course_name']; ?>">
                                       </a>
                                       <div class="card-body">
                                           <h5 class="card-title"><?php echo $courses[$j]['course_name']; ?></h5>
                                           <p class="card-text"><?php echo truncate_words($courses[$j]['course_desc'], 32); ?></p>
                                       </div>
                                   </div>
                               </div>
                           <?php endfor; ?>
                       </div>
                   </div>
                   <?php $active = false; ?>
               <?php endfor; ?>
           </div>
       </div>


       <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="sr-only">Previous</span>
       </a>
       <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
           <span class="carousel-control-next-icon" aria-hidden="true"></span>
           <span class="sr-only">Next</span>
       </a>
   </div>
</main>


<?php require_once 'includes/footer.php'; ?>


<?php
function truncate_words($string, $word_limit) {
   $words = explode(' ', $string);
   if (count($words) > $word_limit) {
       return implode(' ', array_slice($words, 0, $word_limit)) . '...';
   } else {
       return $string;
   }
}
?>
