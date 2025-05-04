<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/mVLBxmf8/Heart-Space-Logo-White-BG.png"> -->
     <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png">
    <title>Home</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>
        body{
    /* background-color: #EE4B2B; */
    /* background: linear-gradient(to right, #ff3366, #6a0dad); */
    background-color: #FFCCE1;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  /* Container for all content */
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  
  .header{
    /* background: linear-gradient(to right, #00b4db, #8a2be2); */
    /* background: linear-gradient(to right, #6a00f4, #00c9ff, #ffeb00, #ff7300, #ff0000); */
    background-color: #F2F9FF;
    /* background-color: burlywood; */
    /* background-color: aqua; */
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px;
    border-radius: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }
  
  .logo{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap:20px;
  }
  
  b{
    color: #EE4B2B;
  }
  
  .pages{
    font-size: 30px;
    display: flex;
    gap: 30px;
  }
  
  a{
    color: black;
    padding: 5px;
  }
  
  a:link{
    color: black;
    text-decoration: none;
  }
a:hover{
    /* background: linear-gradient(to right, #ff007f, #3b5998); */
    /* background: linear-gradient(to right, #ff3366, #6a0dad); */
    background-color: skyblue;
    border-radius: 10px;
    color: #EE4B2B;
    text-decoration: none;
    transition: all 0.3s ease;
  }
  a:active{
    color: white;
    text-decoration: none;
  }
  
  .register{
    display: flex;
    gap: 30px;
    justify-content: center;
    /* font-size: 30px; */
  }
  
  .iconpages{
    display: flex;
    align-items: center;  
    text-decoration: none; 
    font-size: 30px; 
    color: black;
    /* color: #EE4B2B; */
  }

  .iconpages.active {
  background-color: skyblue;
  border-radius: 10px;
  color: #EE4B2B;
  font-weight: bold;
}


  
  .iconimg{
    width: 30px;  
    height: 30px;
    
  }
  
  button{
    font-size: 20px;
    border: 3px solid;
    border-radius: 10px;
    background-color: gray;
    cursor: pointer;
    
    
  }
  button:link{
    /* color: skyblue; */
    text-decoration: none;
  }
  button:hover{
    /* background: linear-gradient(to right, #ff3366, #6a0dad); */
    background-color: skyblue;
    border-radius: 10px;
    color: black;
    /* color: #EE4B2B; */
  
    text-decoration: none;
    transition: all 0.3s ease;
  }
  button:active{
    text-decoration: none;
  }
  
  .signup{
    color: black;
  }
  
  .welcome{
    /* background: linear-gradient(to right, #6a00f4, #00c9ff, #ffeb00, #ff7300, #ff0000); */
    /* padding: 10px; */
    padding: 0px 10px 0px 10px;
    background-color: skyblue;
    /* background-color: #FFF5D7; */
    /* background: linear-gradient(to right, #fff5d7, skyblue, skyblue, skyblue , #fff5d7); */

    border-radius: 35px;
    margin: 0px 350px 0px 350px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  .logout{
    background-color: black;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
  }
  button.logout:hover{
    background-color: #EE4B2B;
    color: white;
    text-decoration: underline;
  }

  .w{
    text-align: center;
  }
  
  .h1{
    color: navy;
  }
  
  .poetry{
    text-align: center;
    color: #FF4D4D;
    font-size: 20px;
  }
  
  .t {
    text-align: left;
    margin-left: 100px;
    color: #EE4B2B;
    /* color: black; */
    font-weight: bold;
  }
  
  .i {
    text-align: right;
    margin-right: 100px;
    color: black; /* Golden */
    font-weight: bold;
  }
  
  /* Content containers for all pages */
  .content-container {
    background-color: #FFF5D7;
    border-radius: 20px;
    padding: 20px;
    margin: 20px 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  /* Form styling */
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
  }
  
  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #FFCCE1;
    border-radius: 10px;
    font-size: 16px;
    background-color: white;
  }
  
  .form-group textarea {
    min-height: 120px;
    resize: vertical;
  }
  
  /* Main button style */
  .main-button {
    background-color: #EE4B2B;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 15px;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .main-button:hover {
    background-color: #FF6B6B;
    transform: translateY(-2px);
  }
  
  .main-button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
  }
  
  /* Loading indicator */
  .loading {
    text-align: center;
    padding: 20px;
    color: #666;
    font-style: italic;
  }
  
  /* Responsive adjustments */
  @media (max-width: 1200px) {
    .welcome {
      margin: 0px 150px;
    }
  }
  
  @media (max-width: 992px) {
    .welcome {
      margin: 0px 50px;
    }
    
    .header {
      flex-direction: column;
      padding: 15px;
    }
    
    .logo, .pages, .register {
      margin-bottom: 15px;
    }
  }
  
  @media (max-width: 768px) {
    .welcome {
      margin: 0px 20px;
    }
    
    .poetry .t, .poetry .i {
      margin-left: 20px;
      margin-right: 20px;
      font-size: 18px;
    }
    
    .pages {
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }
    
    .iconpages {
      font-size: 24px;
    }
  }
  
  @media (max-width: 576px) {
    .header {
      border-radius: 0;
    }
    
    .register {
      flex-direction: column;
      gap: 10px;
    }
    
    .welcome {
      border-radius: 20px;
    }
    
    .iconpages {
      font-size: 20px;
    }
    
    .poetry {
      font-size: 16px;
    }
  }
  .footer{
  background-color: gray;
  height: 350px;
    border: 2px solid white;
  border-radius:35px;
  margin:10px;
}
  
     </style>
</head>
<body>
    <div>
        <div class="header">
            <div class="logo">
                <img src="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png" alt="HeartSpace Error" height="95px" width="145px" style="border-radius: 15px;">
                <div class="title">
                    <h1 style="text-decoration: underline; text-decoration-color: black;"><b>HEART</b> SPACE</h1>
                </div>
            </div>

            <div class="pages">
                <a href="index.php" class="iconpages"><img class="iconimg" src="https://i.ibb.co/KcN5ZYhK/Home.png">Home</a>
                <a href="voice.php" class="iconpages"><img class="iconimg" src="https://i.ibb.co/GwCM8tj/Voice.png">Voice</a>
                <a href="text.php" class="iconpages"><img class="iconimg" src="https://i.ibb.co/4nzK5bh5/Text.png">Text</a>
                <a href="chat.php" class="iconpages"><img class="iconimg" src="https://i.ibb.co/4g4YKpmJ/Chat.png">Chat</a>
            </div>

            <div class="register">
                <div>
                  <div>
                    <h2 style="margin-right: 10px; font-weight: bold;"> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> </h2>
                  </div>
                  <div>
                    <!-- <form action="logout.php" method="post">
                      <button type="submit" class="iconpages">
                        <img class="iconimg" src="https://img.icons8.com/?size=100&id=vGj0AluRnTSa&format=png&color=000000" alt="Logout Icon">Logout
                      </button>
                    </form> -->
                    <!-- <form action="logout.php" method="POST" style="text-align:right; margin: 20px;">
                      <button class="logout">
                        Logout
                      </button>
                    </form> -->

                  </div>    
                </div>
                
                <div>
                    <!-- <form action="logout.php" method="post">
                        <button type="submit" class="iconpages">
                            <img class="iconimg" src="https://img.icons8.com/?size=100&id=vGj0AluRnTSa&format=png&color=000000" alt="Logout Icon">Logout
                        </button>
                    </form> -->
                    <form action="logout.php" method="POST" style="text-align:right; margin: 20px;">
                      <button class="logout">
                        Logout
                      </button>
                    </form>
                </div>
              </div>
            </div>
        </div>

        <div class="welcome">
            <div class="w">
                <h1 class="h1">
                    Welcome to HEARTSPACE <br>
                    Your Heart, Finally Unmuted in the Universe.
                </h1>
            </div>
            <div class="poetry">
                <p class="t">
                    This is your HeartSpace, free and bright, <br>
                    Feel the love in this endless space so wide. <br>
                    Speak your heart, your emotions are true, <br>
                    Let your feelings shine, just be you. <br>
                </p>
                <p class="i">
                    In this universe, your voice has a place, <br>
                    No fear, no limits, just embrace. <br>
                    HeartPulse beats with every sound, <br>
                    Where lost hearts are finally found. <br>
                </p>
                <p class="t">
                    Write or talk, say what you feel, <br>
                    Your words are precious, deep and real. <br>
                    If you can’t say it, just write it down, <br>
                    Let your emotions be heard all around. <br>
                </p>
                <p class="i">
                    Let emotions flow like stars so bright, <br>
                    Love and dreams take endless flight. <br>
                    Share your soul, let your voice be free, <br>
                    In this universe, you belong with me. <br>
                </p>
            </div>
        </div>

        <div class="footer">

        </div>
    </div>
    <script src="script.js">
      function openPopup(url) {
    window.open(url, '_blank', 'width=600,height=600'); // You can customize size or behavior
    }

        // Automatically set active class on the current page's navigation link
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".iconpages");
    const currentPath = window.location.pathname;

    links.forEach(link => {
        const href = link.getAttribute("href");
        if (currentPath.endsWith(href)) {
            link.classList.add("active");
        }
    });
});

document.getElementById("uploadForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      fetch('upload.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        document.getElementById("message").innerText = data.message;
        if (data.success) {
          window.location.reload(); // reload to show new audio
        }
      })
      .catch(err => {
        document.getElementById("message").innerText = "Upload failed.";
        console.error("Error uploading:", err);
      });
    });
    </script>
</body>
</html>