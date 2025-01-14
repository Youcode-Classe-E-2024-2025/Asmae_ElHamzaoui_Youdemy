<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>direction</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dadfdc;            
            overflow-x: hidden;
        }
        i{
            font-size:20px;
        }

        .choix{
            height:250px;
            width:250px;
            padding:10px;
            border-radius:100px;
            background-color:#1c4933;
            text-align:center;
            border-top:1px solid #dadfdc;;
            border-left:1px solid #dadfdc;;
            box-shadow: 12px 12px 12px rgba(106, 134, 109, 0.54); /* Ombre */
            transition: transform 0.3s ease; /* Transition pour l'animation */
        }
        .choix i{
            margin-top:30px;
            font-size:200px;
        }
        .choix div{
            margin-top:10px;
            font-size:20px;            
        }


    </style>
</head>
<body>
     <!-- Header -->
   <?php 
   include_once 'header.php';
   ?>

    <main class="py-24 bg-gradient-to-r to-indigo-600" style="color:#1c4933;">
        <div class="flex justify-center gap-20 mx-64 py-24">
            <div class="choix"><a href="registerChef.php"><img src="../assets/images/student.png"><div><a href="registerChef.php" class="font-bold">Etudiant</a></div></div>
            <div class="choix"><a href="register.php"><img src="../assets/images/prof.png"><div><a href="register.php" class="font-bold">Ensiegnant</a></div></div>
        </div>
    </main>
    
</body>
</html>