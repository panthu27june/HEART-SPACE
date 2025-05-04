<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" type="x-icon" href="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png">
    <title>Text</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/text.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
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

        <div class="content-container">
            <div class="text-share-section">
                <h2>Share Your Thoughts</h2>
                <p>Express yourself through words. Write what's in your Heart and share it with the HeartSpace community.</p>
                
                <div class="text-form">
                    <form id="textShareForm">
                        <div class="form-group">
                            <label for="textTitle">Title</label>
                            <input type="text" id="textTitle" name="title" required placeholder="Give your thoughts a title">
                        </div>
                        
                        <div class="form-group">
                            <label for="textContent">Your Message</label>
                            <textarea id="textContent" name="content" required placeholder="What's on your mind? Share your thoughts, feelings, or stories..."></textarea>
                        </div>
                        
                        <div class="form-controls">
                            <span id="charCounter">0 characters</span>
                            <button type="submit" id="shareTextButton" class="main-button">Share</button>
                        </div>
                    </form>
                </div>
                
                <div class="text-formatting-tips">
                    <h3>Formatting Tips</h3>
                    <ul>
                        <li>Use *asterisks* for italic text</li>
                        <li>Use **double asterisks** for bold text</li>
                        <li>Start lines with > for blockquotes</li>
                        <li>Use line breaks for paragraphs</li>
                    </ul>
                </div>
            </div>
            
            <div class="text-library">
                <h2>HeartSpace Text Library</h2>
                <p>Read thoughts shared by the HeartSpace community</p>
                
                <div class="text-filter">
                    <input type="text" id="searchText" placeholder="Search by title or content">
                    <select id="sortText">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title">Title (A-Z)</option>
                    </select>
                </div>
                
                <div id="textList" class="text-list">
                    <!-- Text shares will be loaded here dynamically -->
                    <div class="loading">Loading shared texts...</div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
    <script src="assets/js/text-sharing.js"></script>
    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
