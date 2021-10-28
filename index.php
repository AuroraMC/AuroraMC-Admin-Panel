<!-- Proudly coded by Billy (https://bybilly.uk) -->
<!-- Version: 1.9.2 -->

<?php
include_once "database/db-connect.php";
include_once "utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Info meta tags, important for social media + SEO -->
    <title>AuroraMC Leadership Panel | The AuroraMC Network</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon"
          type="image/png"
          href="img/logo.png">
</head>
<body>
<div class="container">
    <div class="logo">
        <!-- In the img folder, upload your logo -->
        <!-- Make sure you name it 'logo.png' or update the code below -->
        <img src="img/logo.png" alt="AuroraMC logo">
    </div>

    <div class="items">
        <?php if ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "RC" || $account_type == "SR_DEV") :?>
        <a href="/rules/" class="item rules">
            <div>
                <img src="img/rules.png" alt="Rules icon" class="img">
                <p class="subtitle">Manage the</p>
                <p class="title">Rules</p>
            </div>
        </a>
        <?php endif; ?>
        <?php if ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "RC" || $account_type == "APPEALS" || $account_type == "STAFF" || $account_type == "QA") :?>
        <a href="/punishments/" class="item punishments">
            <div>
                <img src="img/punishments.png" alt="Punishments icon" class="img">
                <p class="subtitle">View player</p>
                <p class="title">Punishments</p>
            </div>
        </a>
        <?php endif; ?>
        <?php if ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "RC" || $account_type == "APPEALS" || $account_type == "QA") :?>
        <a href="/blacklist/" class="item blacklist">
            <div>
                <img src="img/blacklist.png" alt="Blacklist icon" class="img">
                <p class="subtitle">View our</p>
                <p class="title">Name Blacklist</p>
            </div>
        </a>
        <?php endif; ?>
        <?php if ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "DEV" || $account_type == "RC" || $account_type == "QA") :?>
        <a href="/filter/" class="item filter">
            <div>
                <img src="img/filter.png" alt="Filter icon" class="img">
                <p class="subtitle">View our</p>
                <p class="title">Chat Filter</p>
            </div>
        </a>
        <?php endif; ?>
        <?php if ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "DEV") :?>
        <a href="/mission-control/" class="item mission-control">
            <div>
                <img src="img/mission-control.png" alt="Mission Control icon" class="img">
                <p class="subtitle">Access</p>
                <p class="title">Mission Control</p>
            </div>
        </a>
        <?php endif; ?>
        <?php if ($account_type == "OWNER") :?>
        <a href="https://auroramc.block2block.me/" class="item mission-control">
            <div>
                <img src="img/mysql.png" alt="MySQL icon" class="img">
                <p class="subtitle">Access</p>
                <p class="title">phpMyAdmin</p>
            </div>
        </a>
        <?php endif; ?>

        <br><br><br><br>

        <?php if ($account_type == "OWNER") :?>
            <a href="https://panel.auroramc.block2block.me/" class="item">
                <div>
                    <img src="img/pterodactyl.png" alt="Pterodactyl icon" class="img">
                    <p class="subtitle">Access</p>
                    <p class="title">Pterodactyl</p>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($account_type == "OWNER" || $account_type == "SR_DEV" || $account_type == "DEV") :?>
            <a href="https://ci.auroramc.block2block.me/" class="item">
                <div>
                    <img src="img/jenkins.png" alt="Jenkins icon" class="img">
                    <p class="subtitle">Access</p>
                    <p class="title">Jenkins</p>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($account_type == "OWNER" || $account_type == "SR_DEV" || $account_type == "DEV") :?>
            <a href="https://bitbucket.block2block.me/" class="item">
                <div>
                    <img src="img/bitbucket.png" alt="BitBucket icon" class="img">
                    <p class="subtitle">Access</p>
                    <p class="title">BitBucket</p>
                </div>
            </a>
        <?php endif; ?>

        <?php if ($account_type == "OWNER" ||  $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "DEV" ||  $account_type == "QA") :?>
            <a href="https://jira.block2block.me/" class="item">
                <div>
                    <img src="img/jira.png" alt="Jira icon" class="img">
                    <p class="subtitle">Access</p>
                    <p class="title">Jenkins</p>
                </div>
            </a>
        <?php endif; ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/firefly.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
