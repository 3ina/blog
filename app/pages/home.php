
<?php include '../app/pages/includes/header.php'; ?>

<h3 class="mx-4">Featured</h3>

<div class="row my-2 justify-content-center">

    <?php

    $query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id order by id desc limit 6";
    $rows = run_query($query);
    if($rows)
    {
        foreach ($rows as $row) {
            include '../app/pages/includes/post-card.php';
        }

    }else{

        echo "No items found!";
    }

    ?>

</div>

<?php include '../app/pages/includes/footer.php'; ?>