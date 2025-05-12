document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const recordButton = document.getElementById('recordButton');
    const stopButton = document.getElementById('stopButton');
    const audioPreview = document.getElementById('audioPreview');
    const visualizer = document.getElementById('visualizer');
    const timerDisplay = document.getElementById('timer');
    const saveButton = document.getElementById('saveButton');
    const voiceUploadForm = document.getElementById('voiceUploadForm');
    const audioFileInput = document.getElementById('audioFile');
    
    // Recorder state
    let mediaRecorder;
    let audioChunks = [];
    let audioBlob = null;
    let startTime;
    let timerInterval;
    let audioContext;
    let analyser;
    let canvas;
    let canvasCtx;
    let isRecording = false;
    const MAX_RECORDING_TIME = 90; // 90 seconds max
    
    // Initialize canvas for visualizer
    canvas = visualizer;
    canvasCtx = canvas.getContext('2d');
    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
    canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Format time display (MM:SS)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds = Math.floor(seconds % 60);
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Start timer function
    function startTimer() {
        startTime = Date.now();
        timerDisplay.textContent = '00:00';
        
        timerInterval = setInterval(() => {
            const elapsedTime = (Date.now() - startTime) / 1000;
            timerDisplay.textContent = formatTime(elapsedTime);
            
            // Stop recording if max time reached
            if (elapsedTime >= MAX_RECORDING_TIME) {
                stopRecording();
            }
        }, 1000);
    }
    
    // Stop timer function
    function stopTimer() {
        clearInterval(timerInterval);
    }
    
    // Visualizer function
    function visualize(stream) {
        if (!audioContext) {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }
        
        const source = audioContext.createMediaStreamSource(stream);
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 256;
        source.connect(analyser);
        
        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);
        
        canvasCtx.clearRect(0, 0, canvas.width, canvas.height);
        
        function draw() {
            if (!isRecording) return;
            
            requestAnimationFrame(draw);
            analyser.getByteFrequencyData(dataArray);
            
            canvasCtx.fillStyle = '#FFF5D7';
            canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
            
            const barWidth = (canvas.width / bufferLength) * 2.5;
            let barHeight;
            let x = 0;
            
            for (let i = 0; i < bufferLength; i++) {
                barHeight = dataArray[i];
                
                canvasCtx.fillStyle = `rgb(${barHeight + 100}, ${105}, ${50})`;
                canvasCtx.fillRect(x, canvas.height - barHeight / 2, barWidth, barHeight / 2);
                
                x += barWidth + 1;
            }
        }
        
        draw();
    }
    
    // Start recording function
    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                isRecording = true;
                recordButton.classList.add('recording');
                recordButton.innerHTML = '<i data-feather="mic"></i> Recording...';
                feather.replace();
                stopButton.disabled = false;
                saveButton.disabled = true;
                
                audioChunks = [];
                mediaRecorder = new MediaRecorder(stream);
                
                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };
                
                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPreview.src = audioUrl;
                    audioPreview.style.display = 'block';
                    saveButton.disabled = false;
                };
                
                startTimer();
                visualize(stream);
                mediaRecorder.start();
            })
            .catch(error => {
                console.error('Error accessing microphone:', error);
                alert('Unable to access your microphone. Please check your permissions and try again.');
            });
    }
    
    // Stop recording function
    function stopRecording() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') return;
        
        isRecording = false;
        recordButton.classList.remove('recording');
        recordButton.innerHTML = '<i data-feather="mic"></i> Start Recording';
        feather.replace();
        stopButton.disabled = true;
        
        stopTimer();
        mediaRecorder.stop();
        
        // Stop all audio tracks
        mediaRecorder.stream.getTracks().forEach(track => track.stop());
        
        // Reset canvas
        canvasCtx.fillStyle = '#FFF5D7';
        canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
    }
    
    // Event Listeners
    recordButton.addEventListener('click', () => {
        if (isRecording) {
            stopRecording();
        } else {
            startRecording();
        }
    });
    
    stopButton.addEventListener('click', stopRecording);
    
    // File input change handler
    audioFileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            
            // Check file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size exceeds 5MB limit. Please choose a smaller file.');
                e.target.value = '';
                return;
            }
            
            // Check file type
            if (!file.type.match('audio.*')) {
                alert('Please select an audio file.');
                e.target.value = '';
                return;
            }
            
            // Update audio preview
            audioBlob = file;
            const audioUrl = URL.createObjectURL(file);
            audioPreview.src = audioUrl;
            audioPreview.style.display = 'block';
            saveButton.disabled = false;
        }
    });
    
    // Form submission
    voiceUploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        const title = document.getElementById('voiceTitle').value;
        const description = document.getElementById('voiceDescription').value;
        
        if (!title) {
            alert('Please enter a title for your recording.');
            return;
        }
        
        if (!audioBlob && !audioFileInput.files.length) {
            alert('Please record audio or upload a file first.');
            return;
        }
        
        // Add form data
        formData.append('title', title);
        formData.append('description', description);
        
        // Add audio file - either recorded or uploaded
        if (audioFileInput.files.length > 0) {
            formData.append('audioFile', audioFileInput.files[0]);
        } else if (audioBlob) {
            formData.append('audioFile', audioBlob, 'recording.wav');
        }
        
        // Show loading state
        saveButton.disabled = true;
        saveButton.textContent = 'Uploading...';
        
        // Submit to server
        fetch('api/record_voice.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Voice recording uploaded successfully!');
                
                // Reset form
                voiceUploadForm.reset();
                audioPreview.src = '';
                audioPreview.style.display = 'none';
                audioBlob = null;
                
                // Refresh voice list
                loadVoiceRecordings();
            } else {
                throw new Error(data.message || 'Unknown error occurred');
            }
        })
        .catch(error => {
            console.error('Error uploading voice recording:', error);
            alert('Error uploading: ' + error.message);
        })
        .finally(() => {
            saveButton.disabled = false;
            saveButton.textContent = 'Save & Share';
        });
    });
    
    // Load voice recordings on page load
    loadVoiceRecordings();
});

// Function to load voice recordings from server
function loadVoiceRecordings() {
    const voiceList = document.getElementById('voiceList');
    const searchInput = document.getElementById('searchVoice');
    const sortSelect = document.getElementById('sortVoice');
    
    voiceList.innerHTML = '<div class="loading">Loading shared voices...</div>';
    
    // Get filter values
    const searchTerm = searchInput ? searchInput.value : '';
    const sortBy = sortSelect ? sortSelect.value : 'newest';
    
    // Fetch recordings from server
    fetch(`api/get_voices.php?search=${encodeURIComponent(searchTerm)}&sort=${sortBy}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.recordings.length === 0) {
                    voiceList.innerHTML = '<div class="no-results">No voice recordings found</div>';
                    return;
                }
                
                voiceList.innerHTML = '';
                
                data.recordings.forEach(recording => {
                    const recordingDate = new Date(recording.created_at);
                    const formattedDate = recordingDate.toLocaleString();
                    
                    const recordingElement = document.createElement('div');
                    recordingElement.className = 'voice-item';
                    recordingElement.innerHTML = `
                        <div class="voice-item-header">
                            <h3 class="voice-item-title">${escapeHtml(recording.title)}</h3>
                            <span class="voice-item-time">${formattedDate}</span>
                        </div>
                        ${recording.description ? `<p class="voice-item-description">${escapeHtml(recording.description)}</p>` : ''}
                        <p class="voice-item-user">Shared by: ${escapeHtml(recording.username)}</p>
                        <div class="voice-item-player">
                            <audio controls src="${recording.file_path}"></audio>
                        </div>
                    `;
                    
                    voiceList.appendChild(recordingElement);
                });
            } else {
                voiceList.innerHTML = `<div class="error-message">Error: ${data.message || 'Unknown error'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error fetching voice recordings:', error);
            voiceList.innerHTML = `<div class="error-message">Failed to load recordings. Please try again later.</div>`;
        });
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Set up event listeners for search and sort
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchVoice');
    const sortSelect = document.getElementById('sortVoice');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(loadVoiceRecordings, 300));
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', loadVoiceRecordings);
    }
});

// Debounce helper function
function debounce(func, delay) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}
