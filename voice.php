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
    <style>
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

  .footer {
  background-color: gray;
  color: #fff;
  padding: 10px 190px 10px 190px;
  border-radius: 25px;
  border: 2px solid #ffffff20;
  margin: 20px auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  text-align: center;
  font-family: 'Poppins', sans-serif;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
  max-width: 1100px;
}

div.uh a:hover{
    background-color: gray;
    color: black;
  }

.footer .lo img {
  width: 145px;
  height: 95px;
  border-radius: 15px;
  box-shadow: 0 0 10px #ee4b2b88;
}

.footer h1 {
  font-size: 24px;
  color: #EE4B2B;
  margin-bottom: 8px;
}

.footer h2 {
  font-size: 14px;
  color: #cccccc;
  font-weight: normal;
  margin-bottom: 15px;
  font-style: italic;
}

.footer .pa h2:first-child,
.footer .pr h2:first-child {
  font-size: 16px;
  font-weight: bold;
  color: black;
  font-style: normal;
}

.footer a {
  color: #ffffff;
  text-decoration: none;
  display: inline-block;
  margin: 5px 0;
  font-size: 14px;
  transition: all 0.3s ease;
  /* background-color: #2e2e2e; */
  padding: 6px 12px;
  border-radius: 15px;
}

/* .footer a:hover {
  background-color: #EE4B2B;
  color: #fff;
  box-shadow: 0 0 8px #EE4B2B;
} */

/* Responsive Layout */
@media (max-width: 768px) {
  .footer {
    flex-direction: column;
    text-align: center;
    align-items: center;
  }

  .footer .lo,
  .footer .pa,
  .footer .pr {
    width: 100%;
  }

  .footer h1 {
    font-size: 20px;
  }

  .footer h2 {
    font-size: 13px;
  }

  .footer a {
    font-size: 13px;
    padding: 5px 10px;
  }
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
                        <button id="startBtn" class="control-button">
                            <i data-feather="mic"></i> Start Recording
                        </button>
                        <button id="stopBtn" class="control-button" disabled>
                            <i data-feather="square"></i> Stop Recording
                        </button>
                        <div id="timer">00:00</div>
                    </div>
                    
                    <div class="audio-visualizer">
                        <canvas id="visualizer" width="500" height="100"></canvas>
                    </div>
                    
                    <div class="audio-preview">
                        <audio id="preview" controls></audio>
                    </div>
                </div>
                <div class="upload-form">
                    <form id="uploadForm" method="POST" action="upload_voice.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="voiceTitle" >Title</label>
                            <input type="text" id="voiceTitle" name="title" required placeholder="Give your recording a title">
                        </div>
                        
                        <div class="form-group">
                            <label for="voiceDescription">Description (optional)</label>
                            <textarea id="voiceDescription" name="description" placeholder="What's this recording about?"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="audioFile" type="hidden" name="recordedAudio" id="recordedAudio">Or upload an audio file (MP3, WAV, OGG - Max 5MB)</label>
                            <input type="file" id="audioFile" name="audioFile" accept="audio/*">
                        </div>
                        <input type="submit" value="Upload">

                        <!-- <button type="submit" id="saveButton" class="main-button" value="Upload">Save & Share</button> -->
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
        <div class="footer">
        <div class="lo">
          
          <img src="https://i.ibb.co/Sw6myQGM/Screenshot-2025-04-28-105042.png" alt="HeartSpace Error" height="95px" width="145px" style="border-radius: 15px;">
        </div>
        <div>
        <div class="title">
                    <h1 style="text-decoration: underline; color: black;"><b>HEART</b> SPACE<h1>
                      <h2 style="color:white;">
                        Your Heart, Finally Unmuted in the Universe.
                      </h2>
                </div>
          </div>
        <div class="pa">
          <div>
            <h2>
              Resources
            </h2>
          </div>
          <div class="uh">
            <a href="index.php" class="h">Home</a> <br>
            <a href="voice.php" class="v">Voice</a> <br>
            <a href="text.php" class="te">Text</a> <br>
            <a href="chat.php" class="c">Chat</a>
          </div>
        </div>
        <div class="pr">
  <div>
    <div>
      <h2>
        Media
      </h2>
    </div>
    <div class="uh">
      <h2>
      <a href="https://prezi.com/view/OxHbC5bgJvt9LUesxJBE/" target="_blank" class="h" style="display: flex; align-items: center; gap: 8px;">
        <img src="https://img.icons8.com/?size=100&id=8JgRjpFgiV6g&format=png&color=000000" alt="Presentation Icon" width="20" height="20">
        Presentation
      </a>
    </h2>
    </div>
    
  </div>
  <div class="uh">
    <h2>
      <a href="Heart Space.pdf" target="_blank" class="h" style="display: flex; align-items: center; gap: 8px;">
        <img src="https://img.icons8.com/?size=100&id=53380&format=png&color=000000" alt="Project Report Icon" width="20" height="20">
        Project Report
      </a>
    </h2>
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

let mediaRecorder;
let recordedChunks = [];
let recordingBlob;

document.getElementById("startBtn").addEventListener("click", async () => {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(stream);
    recordedChunks = [];

    mediaRecorder.ondataavailable = (e) => {
        if (e.data.size > 0) recordedChunks.push(e.data);
    };

    mediaRecorder.onstop = () => {
        recordingBlob = new Blob(recordedChunks, { type: 'audio/webm' });
        const audioURL = URL.createObjectURL(recordingBlob);
        document.getElementById("preview").src = audioURL;
    };

    mediaRecorder.start();
    document.getElementById("startBtn").disabled = true;
    document.getElementById("stopBtn").disabled = false;
});

document.getElementById("stopBtn").addEventListener("click", () => {
    mediaRecorder.stop();
    document.getElementById("startBtn").disabled = false;
    document.getElementById("stopBtn").disabled = true;
});

// Submit form with recorded audio
document.getElementById("uploadForm").addEventListener("submit", function(e) {
    if (recordingBlob) {
        e.preventDefault(); // Stop default form
        const formData = new FormData(this);
        formData.append("recordedAudio", recordingBlob, "recorded_audio.webm");

        fetch("upload_voice.php", {
            method: "POST",
            body: formData
        }).then(response => response.text())
          .then(data => {
              alert("Audio uploaded!");
              console.log(data);
              location.reload();
          }).catch(err => {
              alert("Upload failed: " + err);
          });
    }
});
</script>

</body>
</html>
