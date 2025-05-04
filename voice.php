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
    <title>Voice</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/voice.css">
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
            <div class="voice-section">
                <h2>Record Your Voice</h2>
                <p>Share your thoughts, feelings, or just say hello. Maximum recording time: 90 seconds.</p>
                
                <div class="recorder-container">
                    <div class="recorder-controls">
                        <button id="recordButton" class="control-button">
                            <i data-feather="mic"></i> Start Recording
                        </button>
                        <button id="stopButton" class="control-button" disabled>
                            <i data-feather="square"></i> Stop Recording
                        </button>
                        <div id="timer">00:00</div>
                    </div>
                    
                    <div class="audio-visualizer">
                        <canvas id="visualizer" width="500" height="100"></canvas>
                    </div>
                    
                    <div class="audio-preview">
                        <audio id="audioPreview" controls></audio>
                    </div>
                </div>
                
                <div class="upload-form">
                    <form id="voiceUploadForm">
                        <div class="form-group">
                            <label for="voiceTitle">Title</label>
                            <input type="text" id="voiceTitle" name="title" required placeholder="Give your recording a title">
                        </div>
                        
                        <div class="form-group">
                            <label for="voiceDescription">Description (optional)</label>
                            <textarea id="voiceDescription" name="description" placeholder="What's this recording about?"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="audioFile">Or upload an audio file (MP3, WAV, OGG - Max 5MB)</label>
                            <input type="file" id="audioFile" name="audioFile" accept="audio/*">
                        </div>
                        
                        <button type="submit" id="saveButton" class="main-button" disabled>Save & Share</button>
                    </form>
                </div>
            </div>
            
            <div class="voice-library">
                <h2>HeartSpace Voice Library</h2>
                <p>Listen to shared voices from the HeartSpace community</p>
                
                <div class="voice-filter">
                    <input type="text" id="searchVoice" placeholder="Search by title or description">
                    <select id="sortVoice">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title">Title (A-Z)</option>
                    </select>
                </div>
                
                <div id="voiceList" class="voice-list">
                    <!-- Voice recordings will be loaded here dynamically -->
                    <div class="loading">Loading shared voices...</div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
    <script src="assets/js/recorder.js"></script>
    <script src="assets/js/audio-player.js"></script>
    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
