<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

$user = $_SESSION['user'];

$stepTitle = $_GET['step'] ?? 'Learning Topic';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($stepTitle); ?> | AI Learn
    </title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=3">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        .learning-main {
            max-width: 1000px;
            margin: 0 auto;
        }

        .learning-header {
            background: linear-gradient(135deg,#4F46E5,#06B6D4);
            color: white;
            padding: 45px;
            border-radius: 24px;
            margin-bottom: 25px;
        }

        .learning-header h1 {
            color: white;
            margin: 12px 0;
        }

        .learning-header p {
            color: rgba(255,255,255,.9);
            line-height: 1.7;
        }

        .learning-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
        }

        .learning-card h2 {
            margin-bottom: 15px;
            color: #111827;
        }

        .learning-card p {
            color: #64748b;
            line-height: 1.7;
        }

        .learning-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .learning-btn {
            padding: 13px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .primary-learning-btn {
            background: linear-gradient(135deg,#4F46E5,#06B6D4);
            color: white;
        }

        .secondary-learning-btn {
            background: #f1f5f9;
            color: #334155;
        }

        @media(max-width:700px) {

            .learning-header,
            .learning-card {
                padding: 25px;
            }

            .learning-actions {
                flex-direction: column;
            }

        }

    </style>

</head>

<body>

<div class="dashboard-container">

    <main class="dashboard-main">

        <div class="learning-main">

            <!-- HEADER -->

            <section class="learning-header">

                <span>
                    <i class="fa-solid fa-graduation-cap"></i>
                    NOW LEARNING
                </span>

                <h1>
                    <?php echo htmlspecialchars($stepTitle); ?>
                </h1>

                <p>
                    Continue your personalized learning journey
                    and build your skills step by step.
                </p>

            </section>


            <!-- CONTENT -->

            <section class="learning-card">

                <h2>
                    What You'll Learn
                </h2>

                <p>

                    This learning section will contain lessons,
                    explanations, examples and practical exercises
                    for this roadmap topic.

                </p>

            </section>


            <!-- PRACTICE -->

            <section class="learning-card">

                <h2>
                    Practice & Build 🚀
                </h2>

                <p>

                    After learning the concepts, practice them with
                    small exercises and build a practical project.

                </p>

            </section>


            <!-- ACTIONS -->

            <div class="learning-actions">

                <a
                    href="../dashbord/roadmap.php"
                    class="learning-btn secondary-learning-btn">

                    <i class="fa-solid fa-arrow-left"></i>

                    Back to Roadmap

                </a>

                <button
                    class="learning-btn primary-learning-btn"
                    onclick="completeLearning()">

                    <i class="fa-solid fa-check"></i>

                    Mark as Complete

                </button>

            </div>

        </div>

    </main>

</div>


<script>

function completeLearning() {

    alert(
        "Great job! 🎉\n\n" +
        "This learning step has been completed."
    );

}

</script>

</body>

</html>