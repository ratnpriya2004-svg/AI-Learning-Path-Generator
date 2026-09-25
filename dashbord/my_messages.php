<?php

session_start();

include("../config/database.php");


// =====================================
// CHECK LOGIN
// =====================================

if (!isset($_SESSION['user'])) {

    header("Location: ../login.html");
    exit();

}

$user = $_SESSION['user'];


// =====================================
// GET USER SUPPORT MESSAGES
// =====================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM support_messages
     WHERE username = ?
     ORDER BY id DESC"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $user
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Messages | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=5">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>

/* =========================================
   MY MESSAGES PAGE
========================================= */

.messages-container {
    width: 100%;
    max-width: 1050px;
    margin: 0 auto;
}


/* =========================================
   HEADER / HERO
========================================= */

/* =========================================
   MESSAGES LIST
========================================= */

.messages-list {
    display: flex;
    flex-direction: column;
    gap: 20px;

    width: 100%;
}


/* =========================================
   SINGLE MESSAGE CARD
========================================= */

.message-card {
    width: 100%;
    box-sizing: border-box;

    background: #ffffff;

    border: 1px solid #e2e8f0;
    border-radius: 18px;

    padding: 24px 26px;

    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        border-color 0.2s ease;
}


/* Hover effect */

.message-card:hover {
    transform: translateY(-2px);

    border-color: #c7d2fe;

    box-shadow:
        0 8px 25px rgba(15, 23, 42, 0.08);
}


/* =========================================
   CARD HEADER
========================================= */

.message-card-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    margin-bottom: 20px;

    padding-bottom: 16px;

    border-bottom: 1px solid #f1f5f9;
}


/* =========================================
   MESSAGE NUMBER
========================================= */

.message-number {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 42px;
    height: 30px;

    padding: 0 10px;

    border-radius: 8px;

    background: #eef2ff;

    color: #4F46E5;

    font-size: 13px;

    font-weight: 700;
}


/* =========================================
   USER SECTION
========================================= */

.message-user {
    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 20px;
}


/* User icon */

.user-icon {
    width: 42px;
    height: 42px;

    min-width: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #eef2ff;

    color: #4F46E5;

    font-size: 17px;
}


/* User details */

.user-details {
    display: flex;

    flex-direction: column;

    gap: 4px;
}

.user-details strong {
    color: #111827;

    font-size: 16px;
}

.user-details span {
    color: #64748b;

    font-size: 13px;
}

.user-details span i {
    margin-right: 5px;
}


/* =========================================
   SUBJECT
========================================= */

.message-subject {
    color: #111827;

    font-size: 20px;

    font-weight: 700;

    line-height: 1.4;

    margin-bottom: 7px;
}


/* =========================================
   DATE
========================================= */

.message-date {
    display: flex;

    align-items: center;

    gap: 6px;

    color: #64748b;

    font-size: 13px;

    margin-bottom: 20px;
}


/* =========================================
   MESSAGE CONTENT
========================================= */

.message-content {
    background: #f8fafc;

    border: 1px solid #f1f5f9;

    border-radius: 12px;

    padding: 17px 19px;
}


/* Message label */

.message-label {
    display: flex;

    align-items: center;

    gap: 7px;

    color: #475569;

    font-size: 13px;

    font-weight: 700;

    margin-bottom: 9px;
}


/* Message paragraph */

.message-content p {
    margin: 0;

    color: #475569;

    font-size: 15px;

    line-height: 1.7;

    word-break: break-word;
}


/* =========================================
   STATUS
========================================= */

.status {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;
}


/* Pending */

.status-pending {
    background: #fef3c7;

    color: #92400e;
}


/* Resolved */

.status-read {
    background: #dcfce7;

    color: #166534;
}


/* Replied */

.status-replied {
    background: #ede9fe;

    color: #6d28d9;
}


/* =========================================
   EMPTY STATE
========================================= */

.empty-messages {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 18px;

    padding: 60px 25px;

    text-align: center;

    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
}

.empty-messages i {
    display: block;

    font-size: 48px;

    color: #4F46E5;

    margin-bottom: 15px;
}

.empty-messages h2 {
    color: #111827;

    margin-bottom: 8px;
}

.empty-messages p {
    color: #64748b;

    margin-bottom: 20px;
}


/* =========================================
   BACK BUTTON
========================================= */

.back-btn {
    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 11px 18px;

    margin-bottom: 25px;

    border-radius: 10px;

    background: #eef2ff;

    color: #4F46E5;

    text-decoration: none;

    font-weight: 600;
}

.back-btn:hover {
    background: #e0e7ff;
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 700px) {

    .message-card {
        padding: 20px;
    }

    .message-card-header {
        align-items: flex-start;
    }

    .message-subject {
        font-size: 18px;
    }

    .message-user {
        margin-bottom: 17px;
    }

    .message-content {
        padding: 15px;
    }

}
</style>

</head>


<body>


<div class="dashboard-container">


    <!-- =====================================
         HEADER
    ===================================== -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>My Messages</h1>

                <p>
                    View your support requests 📩
                </p>

            </div>

        </div>


        <div class="header-right">

            <div
                class="profile-icon"
                onclick="window.location.href='profile.php'"
                title="My Profile">

                <i class="fa-solid fa-user"></i>

            </div>


            <button
                class="menu-button"
                id="menuButton">

                <i class="fa-solid fa-ellipsis-vertical"></i>

            </button>

        </div>

    </header>



    <!-- =====================================
         SIDEBAR
    ===================================== -->

    <aside class="sidebar">

        <button
            class="close-menu"
            id="closeMenu">

            <i class="fa-solid fa-xmark"></i>

        </button>


        <div class="sidebar-logo">

            <i class="fa-solid fa-brain"></i>

            <span>AI Learn</span>

        </div>


        <nav class="sidebar-menu">


            <a href="dashboard.php">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>


            <a href="roadmap.php">

                <i class="fa-solid fa-road"></i>

                <span>My Roadmap</span>

            </a>


            <a href="progress.php">

                <i class="fa-solid fa-chart-line"></i>

                <span>Progress</span>

            </a>


            <a href="resources.php">

                <i class="fa-solid fa-book"></i>

                <span>Resources</span>

            </a>


            <a href="profile.php">

                <i class="fa-solid fa-user"></i>

                <span>Profile</span>

            </a>


            <a href="about.php">

                <i class="fa-solid fa-circle-info"></i>

                <span>About</span>

            </a>


        </nav>


        <div class="sidebar-bottom">

            <a href="../php/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </a>

        </div>

    </aside>


    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>



    <!-- =====================================
         MAIN CONTENT
    ===================================== -->

    <main class="dashboard-main">


        <div class="messages-container">


            <a
                href="../contact.php"
                class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Contact Support

            </a>


            <section class="messages-header">

                <h2>
                    My Support Messages
                </h2>

                <p>
                    Here you can view the support requests
                    you have submitted.
                </p>

            </section>



            <?php if (mysqli_num_rows($result) > 0): ?>

    <?php
    $messageNumber = 1;
    ?>

    <div class="messages-list">

        <?php while ($message = mysqli_fetch_assoc($result)): ?>

            <?php
            $status = $message['status'] ?? 'Pending';

            if ($status === 'Resolved') {

                $statusClass = 'status-read';
                $statusIcon = 'fa-solid fa-circle-check';

            } elseif ($status === 'Replied') {

                $statusClass = 'status-replied';
                $statusIcon = 'fa-solid fa-reply';

            } else {

                $statusClass = 'status-pending';
                $statusIcon = 'fa-solid fa-clock';
            }
            ?>

            <!-- =========================
                 SINGLE MESSAGE CARD
            ========================== -->

            <article class="message-card">

                <!-- TOP ROW -->

                <div class="message-card-header">

                    <div class="message-number">
                        #<?php echo $messageNumber; ?>
                    </div>

                    <div class="message-status">

                        <span class="status <?php echo $statusClass; ?>">

                            <i class="<?php echo $statusIcon; ?>"></i>

                            <?php echo htmlspecialchars($status); ?>

                        </span>

                    </div>

                </div>


                <!-- USER INFORMATION -->

                <div class="message-user">

                    <div class="user-icon">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <div class="user-details">

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $message['username'] ?? $user
                            );
                            ?>
                        </strong>

                        <span>

                            <i class="fa-solid fa-envelope"></i>

                            <?php

                            if (!empty($message['email'])) {

                                echo htmlspecialchars(
                                    $message['email']
                                );

                            } else {

                                echo "Email not available";

                            }

                            ?>

                        </span>

                    </div>

                </div>


                <!-- SUBJECT -->

                <div class="message-subject">

                    <?php
                    echo htmlspecialchars(
                        $message['subject']
                    );
                    ?>

                </div>


                <!-- DATE -->

                <div class="message-date">

                    <i class="fa-regular fa-clock"></i>

                    <?php
                    echo htmlspecialchars(
                        $message['created_at']
                    );
                    ?>

                </div>


                <!-- MESSAGE -->

                <div class="message-content">

                    <div class="message-label">

                        <i class="fa-regular fa-message"></i>

                        Your Message

                    </div>

                    <p>

                        <?php

                        echo nl2br(
                            htmlspecialchars(
                                $message['message']
                            )
                        );

                        ?>

                    </p>

                </div>

            </article>


            <?php
            $messageNumber++;
            ?>

        <?php endwhile; ?>

    </div>


<?php else: ?>

    <div class="empty-messages">

        <i class="fa-solid fa-envelope-open"></i>

        <h2>
            No Messages Yet
        </h2>

        <p>
            You haven't submitted any support
            requests yet.
        </p>

        <a href="../contact.php" class="back-btn">
            <i class="fa-solid fa-paper-plane"></i>
            Contact Support
        </a>

    </div>

<?php endif; ?>


        </div>


    </main>


</div>


<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=5">
</script>


</body>

</html>


<?php

mysqli_stmt_close($stmt);

?>