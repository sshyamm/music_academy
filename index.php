<?php require_once 'includes/config.php'; ?>
<?php require_once 'includes/header.php'; ?>

<main class="custom-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="img-container">
                    <?php
                    $query = "SELECT * FROM images WHERE image_status = 'Active'";
                    $stmt = $db->prepare($query);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<img src="admin/getForms/img/' . $row["image_path"] . '">';
                    }
                    ?>
                </div>
                <div class="content">
                    <h2 class="heading">Delivering High Quality Music Education Since 2009<br>Your Hobby is our Passion</h2>
                    <button class="btn btn-primary">Learn More</button>
                </div>
                <div class="newsletter-form">
                    <h3>Subscribe to Our Newsletter</h3>
                    <form id="newsletter-form" action="subscribe.php" method="post">
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <button type="submit" id="subscribe-btn" class="btn btn-primary ml-2">Subscribe</button>
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

    $(document).ready(function() {
        $('#newsletter-form').submit(function(e) {
            e.preventDefault(); 

            var formData = $(this).serialize();

            var form = this;

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#success-modal .modal-body').text(response.message);
                        $('#success-modal').modal('show');
                        form.reset(); 
                    } else {
                        $('#error-modal .modal-body').text(response.message);
                        $('#error-modal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); 
                }
            });
        });
    });
    function closeModal(modalId) {
    $('#' + modalId).modal('hide');
  }
</script>
<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="success-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="success-modal-label">Success</h5>
        <button type="button" class="close" aria-label="Close" onclick="closeModal('success-modal')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="error-modal-label">Error</h5>
        <button type="button" class="close" aria-label="Close" onclick="closeModal('error-modal')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>