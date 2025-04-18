<?php
    require_once "./utils/session.php";
    require_once "./utils/user.php";

    if(session_get_user()->username !== $_GET["username"]){
        header("Location: ./index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing @<?php echo session_get_user()->username?></title>
</head>
<body>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        form {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            width: 100%;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

    <form action="process/edit-profile.php?username=<?php echo session_get_user()->username?>" method="POST" enctype="multipart/form-data">
        <fieldset>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="username" value="<?php echo session_get_user()->username?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="exemple@test.com" value="<?php echo session_get_user()->email?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="New Password">

            <label for="profile_photo">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*">

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="first name" value="<?php echo session_get_user()->prenom?>">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="last name" value="<?php echo session_get_user()->nom?>">

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="4" placeholder="bio"><?php echo session_get_user()->bio ?></textarea>
        </fieldset>
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>