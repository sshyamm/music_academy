<head>
  <title>Home</title>
</head>
<?php require_once 'includes/header.php'; ?>
    <main class="custom-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="img-container">
                    <img class="img1" src="img/index1.jpg" alt="Image 1">
                    <img class="img2" src="img/index2.jpg" alt="Image 2">
                    <img class="img3" src="img/index3.jpg" alt="Image 3">
                </div>
                <div class="content">
                    <h2 class="heading">Delivering High Quality Music Education Since 2009<br>Your Hobby is our Passion</h2>
                    <button class="btn btn-primary">Learn More</button>
                </div>
                <div class="newsletter-form">
                    <h3>Subscribe to Our Newsletter</h3>
                    <form action="subscribe.php" method="post">
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <button type="submit" class="btn btn-primary ml-2">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
    <?php require 'includes/footer.php'; ?>
    <script>
        const images = document.querySelectorAll('.img-container img');
        let index = 0;

        setInterval(() => {
            images[index].style.opacity = '0';
            index = (index + 1) % images.length;
            images[index].style.opacity = '1';
        }, 1500);
    </script>
