document.addEventListener("DOMContentLoaded", function () {
    const uploadForm = document.getElementById("uploadForm");
    const audioInput = document.getElementById("audio");
    const uploadStatus = document.getElementById("uploadStatus");
    const audioPreview = document.getElementById("audioPreview");
    const recordingsList = document.getElementById("recordingsList");

    // Show preview before upload
    audioInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file && file.type.startsWith("audio")) {
            const url = URL.createObjectURL(file);
            audioPreview.innerHTML = `
                <audio controls src="${url}" class="w-full mt-2 rounded"></audio>
            `;
        } else {
            audioPreview.innerHTML = '';
        }
    });

    // Handle form submit
    uploadForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(uploadForm);
        uploadStatus.textContent = "Uploading...";

        fetch("upload_voice.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            uploadStatus.textContent = response.includes("success") ? "Upload successful!" : response;
            uploadForm.reset();
            audioPreview.innerHTML = "";
            loadVoiceRecordings();
        })
        .catch(err => {
            console.error("Upload error:", err);
            uploadStatus.textContent = "Upload failed.";
        });
    });

    // Load existing recordings
    function loadVoiceRecordings() {
        fetch("api/get_voices.php")
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error("Invalid response format");
                }
                recordingsList.innerHTML = "";
                data.forEach(voice => {
                    const div = document.createElement("div");
                    div.classList.add("recording");

                    const audio = document.createElement("audio");
                    audio.controls = true;
                    audio.src = voice.filepath;

                    const info = document.createElement("p");
                    info.textContent = `Uploaded by: ${voice.username} at ${voice.uploaded_at}`;

                    div.appendChild(audio);
                    div.appendChild(info);

                    if (voice.is_owner) {
                        const delBtn = document.createElement("button");
                        delBtn.textContent = "Delete";
                        delBtn.classList.add("delete-button");
                        delBtn.addEventListener("click", () => deleteVoice(voice.id));
                        div.appendChild(delBtn);
                    }

                    recordingsList.appendChild(div);
                });
            })
            .catch(err => {
                console.error("Error loading recordings:", err);
                recordingsList.innerHTML = "<p class='text-red-500'>Failed to load recordings.</p>";
            });
    }

    function deleteVoice(id) {
        if (!confirm("Are you sure you want to delete this recording?")) return;

        fetch("delete_voice.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + encodeURIComponent(id)
        })
        .then(res => res.text())
        .then(response => {
            alert(response);
            loadVoiceRecordings();
        })
        .catch(err => {
            console.error("Delete failed:", err);
            alert("Failed to delete recording.");
        });
    }

    // Load on page load
    loadVoiceRecordings();
});
