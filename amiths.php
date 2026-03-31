<?php
$fullName = htmlspecialchars($_POST['fullName'] ?? 'Stevene Amiths');
$profession = htmlspecialchars($_POST['profession'] ?? 'IT Professional');
$email = htmlspecialchars($_POST['email'] ?? 'No email provided');
$phone = htmlspecialchars($_POST['phone'] ?? 'No phone provided');
$address = htmlspecialchars($_POST['address'] ?? 'No address provided');
$summary = htmlspecialchars($_POST['summary'] ?? '');

$skillsRaw = $_POST['skills'] ?? '';
$skillsArray = array_filter(array_map('trim', explode(',', $skillsRaw)));

$exp_title = htmlspecialchars($_POST['exp_title'] ?? '');
$exp_company = htmlspecialchars($_POST['exp_company'] ?? '');
$exp_duration = htmlspecialchars($_POST['exp_duration'] ?? '');
$exp_desc = htmlspecialchars($_POST['exp_desc'] ?? '');

$edu_degree = htmlspecialchars($_POST['edu_degree'] ?? '');
$edu_school = htmlspecialchars($_POST['edu_school'] ?? '');
$edu_year = htmlspecialchars($_POST['edu_year'] ?? '');

$profilePicPath = "default.png";
if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
    $uploadDir = __DIR__ . '/uploads/'; 
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileExtension = pathinfo($_FILES['profilePic']['name'], PATHINFO_EXTENSION);
    $newFileName = md5(time() . $fullName) . '.' . $fileExtension;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $destination)) {
        $profilePicPath = 'uploads/' . $newFileName;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $fullName ?> - Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-col: #7D1128;
            --accent: #FFC107;
            --light-col: #ffffff;
            --text-dark: #333;
            --text-light: #FFC107;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #e9ecef; display: flex; justify-content: center; padding: 40px 20px; font-family: 'Lora', serif; }
        
        .resume-wrapper {
            display: flex;
            width: 100%;
            max-width: 950px;
            background: var(--light-col);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .left-col { width: 35%; background: var(--dark-col); color: var(--text-light); padding: 50px 40px; }
        
        .profile-img-container { text-align: center; margin-bottom: 30px; }
        .profile-img { width: 170px; height: 170px; border-radius: 50%; object-fit: cover; border: 4px solid var(--accent); padding: 5px; background: white; }
        
        .left-section-title { font-family: 'Montserrat', sans-serif; font-size: 1rem; text-transform: uppercase; letter-spacing: 2px; border-bottom: 1px solid rgba(255,193,7,0.2); padding-bottom: 10px; margin: 30px 0 15px; color: var(--accent); font-weight: 700; }
        
        .contact-info p { margin-bottom: 15px; font-size: 0.9rem; font-family: 'Montserrat', sans-serif; line-height: 1.5; color: white; }
        .contact-info span { display: block; font-size: 0.75rem; color: #aaa; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }

        .skills-list { list-style: none; font-family: 'Montserrat', sans-serif; }
        .skills-list li { margin-bottom: 10px; font-size: 0.9rem; padding-left: 15px; position: relative; color: white; }
        .skills-list li::before { content: "•"; color: var(--accent); position: absolute; left: 0; font-size: 1.2rem; top: -2px; }

        .right-col { width: 65%; padding: 60px 50px; position: relative; }
        
        .name-header { margin-bottom: 40px; }
        .name-header h1 { font-family: 'Montserrat', sans-serif; font-size: 3.2rem; font-weight: 800; color: var(--dark-col); line-height: 1.1; margin-bottom: 5px; text-transform: uppercase; }
        .name-header h2 { font-family: 'Montserrat', sans-serif; font-size: 1.4rem; font-weight: 500; color: var(--accent); letter-spacing: 1px; }

        .summary-text { font-size: 1.05rem; line-height: 1.8; color: #555; margin-bottom: 40px; font-style: italic; }

        .right-section-title { font-family: 'Montserrat', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--dark-col); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 25px; display: flex; align-items: center; }
        .right-section-title::after { content: ""; flex: 1; height: 2px; background: var(--accent); margin-left: 15px; opacity: 0.5; }

        .timeline-item { margin-bottom: 30px; }
        .timeline-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 5px; }
        .timeline-title { font-family: 'Montserrat', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--text-dark); }
        .timeline-date { font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 600; color: var(--dark-col); background: var(--accent); padding: 5px 12px; border-radius: 20px;}
        .timeline-subtitle { font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 500; color: #666; margin-bottom: 10px; }
        .timeline-desc { font-size: 0.95rem; line-height: 1.6; color: #555; }

        .btn-create { position: absolute; top: 20px; right: 30px; background: var(--dark-col); color: var(--accent); text-decoration: none; padding: 10px 20px; font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 700; border-radius: 4px; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
        .btn-create:hover { background: #600D1F; }

        @media (max-width: 768px) {
            .resume-wrapper { flex-direction: column; }
            .left-col, .right-col { width: 100%; padding: 30px; }
            .btn-create { position: relative; top: 0; right: 0; display: inline-block; margin-bottom: 20px; }
        }
    </style>
</head>
<body>

    <div class="resume-wrapper">
        <div class="left-col">
            <div class="profile-img-container">
                <img src="<?= $profilePicPath ?>" alt="Profile Picture" class="profile-img">
            </div>

            <h3 class="left-section-title">Contact</h3>
            <div class="contact-info">
                <p><span>Email</span> <?= $email ?></p>
                <p><span>Phone</span> <?= $phone ?></p>
                <p><span>Location</span> <?= $address ?></p>
            </div>

            <h3 class="left-section-title">Expertise</h3>
            <ul class="skills-list">
                <?php foreach ($skillsArray as $skill): ?>
                    <li><?= htmlspecialchars($skill) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="right-col">
            <a href="amiths.html" class="btn-create">Create New CV</a>

            <div class="name-header">
                <h1><?= $fullName ?></h1>
                <h2><?= $profession ?></h2>
            </div>

            <p class="summary-text">"<?= nl2br($summary) ?>"</p>

            <h3 class="right-section-title">Experience</h3>
            <div class="timeline-item">
                <div class="timeline-header">
                    <div class="timeline-title"><?= $exp_title ?></div>
                    <div class="timeline-date"><?= $exp_duration ?></div>
                </div>
                <div class="timeline-subtitle"><?= $exp_company ?></div>
                <div class="timeline-desc"><?= nl2br($exp_desc) ?></div>
            </div>

            <h3 class="right-section-title">Education</h3>
            <div class="timeline-item">
                <div class="timeline-header">
                    <div class="timeline-title"><?= $edu_degree ?></div>
                    <div class="timeline-date"><?= $edu_year ?></div>
                </div>
                <div class="timeline-subtitle"><?= $edu_school ?></div>
            </div>
        </div>
    </div>

</body>
</html>
