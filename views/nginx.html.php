<?php include ROOT . '/views/includes/head.html.php' ?>

    <body class="container">
<header class="mt-5">
    <a href="/">Home</a>
</header>
<main>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" class="mt-5 d-flex justify-content-between">
        <div class="checkboxes">
            <?php if (isset($listOfAllLogs) && is_array($listOfAllLogs)): ?>
                <?php foreach ($listOfAllLogs as $log): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $log ?>"
                               id="defaultCheck1" name="logs[]"
                            <?php if (isset($_GET['logs'])) {
                                foreach ($_GET['logs'] as $checkedLog) {
                                    if ($checkedLog == $log) echo 'checked';
                                }
                            }
                            ?>
                        >
                        <label class="form-check-label" for="defaultCheck1">
                            <?php echo $log ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="form-group d-flex w-50">
            <input type="text" name="searchString" class="form-control" id="search" placeholder="404"
                   value="<?php if (isset($_GET['searchString'])) echo $_GET['searchString']; ?>">
            <button type="submit" class="btn btn-outline-info ml-1">Send</button>
        </div>
    </form>
    <table class="table">
        <?php if (isset($_SESSION) && $_SESSION != NULL): ?>
            <?php foreach ($_SESSION as $file => $values): ?>
                <thead class="thead-dark">
                <tr>
                    <th scope="col"><?php echo $file; ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <?php if (is_array($values)): ?>
                    <?php foreach ($values as $value): ?>
                        <?php
                        $value = explode('@', $value);
                        $stringNumber = $value[0];
                        $string = $value[1];
                        ?>
                        <tbody>
                        <tr>
                            <th scope="row"><?php echo $stringNumber ?></th>
                            <td><?php echo $string ?></td>
                        </tr>
                        </tbody>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"><?php echo SearchNginx::notFound(); ?></th>
            </tr>
            </thead>
        <?php endif; ?>
    </table>
</main>

<?php include ROOT . '/views/includes/footer.html.php' ?>