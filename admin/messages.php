<?php

session_start();

include("../config/database.php");

/* =========================================
   ADMIN LOGIN CHECK
========================================= */

// Abhi temporary admin check.
// Baad mein proper admin login system bana denge.

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}


/* =========================================
   GET SUPPORT MESSAGES
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM support_messages
     ORDER BY id DESC"
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

    <title>Support Messages | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=5">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        .messages-container {

            max-width:1100px;
            margin:0 auto;

        }


        .messages-header {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color:white;

            padding:35px;

            border-radius:22px;

            margin-bottom:25px;

        }


        .messages-header h2 {

            margin:0 0 8px;

            color:white;

        }


        .messages-header p {

            margin:0;

            color:rgba(255,255,255,.9);

        }


        .message-card {

            background:white;

            border:1px solid #e5e7eb;

            border-radius:18px;

            padding:25px;

            margin-bottom:18px;

            box-shadow:
                0 5px 20px rgba(0,0,0,.05);

        }


        .message-top {

            display:flex;

            justify-content:space-between;

            align-items:flex-start;

            gap:20px;

            margin-bottom:18px;

        }


        .message-user {

            display:flex;

            align-items:center;

            gap:14px;

        }


        .message-avatar {

            width:48px;

            height:48px;

            border-radius:50%;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color:white;

            display:flex;

            align-items:center;

            justify-content:center;

        }


        .message-user h3 {

            margin:0 0 4px;

            color:#111827;

        }


        .message-user p {

            margin:0;

            color:#64748b;

            font-size:14px;

        }


        .message-date {

            color:#64748b;

            font-size:13px;

        }


        .message-subject {

            font-size:18px;

            font-weight:700;

            color:#111827;

            margin-bottom:10px;

        }


        .message-text {

            color:#475569;

            line-height:1.7;

            background:#f8fafc;

            padding:18px;

            border-radius:12px;

        }


        .empty-messages {

            background:white;

            border:1px solid #e5e7eb;

            border-radius:18px;

            padding:60px 25px;

            text-align:center;

        }


        .empty-messages i {

            font-size:50px;

            color:#4F46E5;

            margin-bottom:15px;

        }


        .empty-messages h2 {

            color:#111827;

        }


        .empty-messages p {

            color:#64748b;

        }


        @media(max-width:700px) {

            .message-top {

                flex-direction:column;

            }

        }

    </style>

</head>


<body>

<div class="dashboard-container">


    <!-- HEADER -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>Support Messages</h1>

                <p>
                    Manage user support requests 📩
                </p>

            </div>

        </div>


        <div class="header-right">

            <div class="profile-icon">

                <i class="fa-solid fa-user"></i>

            </div>

        </div>

    </header>



    <!-- MAIN -->

    <main class="dashboard-main">

        <div class="messages-container">


            <section class="messages-header">

                <h2>
                    User Support Messages
                </h2>

                <p>
                    View questions, problems and requests
                    submitted by AI Learn users.
                </p>

            </section>



            <?php if (mysqli_num_rows($result) > 0): ?>


                <?php while ($message = mysqli_fetch_assoc($result)): ?>


                    <div class="message-card">


                        <div class="message-top">


                            <div class="message-user">


                                <div class="message-avatar">

                                    <i class="fa-solid fa-user"></i>

                                </div>


                                <div>

                                    <h3>

                                        <?php
                                        echo htmlspecialchars(
                                            $message['name']
                                        );
                                        ?>

                                    </h3>


                                    <p>

                                        <?php
                                        echo htmlspecialchars(
                                           $message['email'] ?? 'No email provided'
                                        );
                                        ?>

                                    </p>

                                </div>


                            </div>


                            <div class="message-date">

                                <?php

                                if (isset($message['created_at'])) {

                                    echo htmlspecialchars(
                                        $message['created_at']
                                    );

                                }

                                ?>

                            </div>


                        </div>



                        <div class="message-subject">

                            <?php
                            echo htmlspecialchars(
                                $message['subject']
                            );
                            ?>

                        </div>


                        <div class="message-text">

                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $message['message']
                                )
                            );
                            ?>

                        </div>
                    
                        <!-- MESSAGE STATUS -->

<div style="
    margin-top:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    flex-wrap:wrap;
">

    <div>

        <strong style="color:#374151;">
            Status:
        </strong>

        <?php
        $status = $message['status'] ?? 'Pending';
        ?>

        <span style="
            display:inline-block;
            margin-left:8px;
            padding:6px 12px;
            border-radius:20px;
            font-size:13px;
            font-weight:600;
            background:#fef3c7;
            color:#92400e;
        ">

            <?php echo htmlspecialchars($status); ?>

        </span>

    </div>


    <!-- STATUS UPDATE FORM -->

    <form
        action="update_message_status.php"
        method="POST"
        style="display:flex; gap:8px; flex-wrap:wrap;"
    >

        <input
            type="hidden"
            name="message_id"
            value="<?php echo (int)$message['id']; ?>"
        >


        <select
            name="status"
            style="
                padding:8px 12px;
                border:1px solid #e2e8f0;
                border-radius:8px;
                background:#fff;
                cursor:pointer;
            "
        >

            <option
                value="Pending"
                <?php echo $status === 'Pending' ? 'selected' : ''; ?>
            >
                Pending
            </option>

            <option
                value="In Progress"
                <?php echo $status === 'In Progress' ? 'selected' : ''; ?>
            >
                In Progress
            </option>

            <option
                value="Resolved"
                <?php echo $status === 'Resolved' ? 'selected' : ''; ?>
            >
                Resolved
            </option>

        </select>


        <button
            type="submit"
            style="
                padding:8px 15px;
                border:none;
                border-radius:8px;
                background:linear-gradient(135deg,#4F46E5,#06B6D4);
                color:white;
                font-weight:600;
                cursor:pointer;
            "
        >

            <i class="fa-solid fa-rotate"></i>

            Update

        </button>

    </form>

</div>

                    </div>


                <?php endwhile; ?>


            <?php else: ?>


                <div class="empty-messages">

                    <i class="fa-solid fa-envelope-open"></i>

                    <h2>
                        No Support Messages
                    </h2>

                    <p>
                        There are currently no messages
                        submitted by users.
                    </p>

                </div>


            <?php endif; ?>


        </div>

    </main>


</div>


</body>

</html>

<?php

mysqli_stmt_close($stmt);

?>