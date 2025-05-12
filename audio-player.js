// assets/js/audio-player.js

document.addEventListener('DOMContentLoaded', () => {
    const voiceList = document.getElementById('voiceList');
    const searchInput = document.getElementById('searchVoice');
    const sortSelect = document.getElementById('sortVoice');

    // Fetch and display voice recordings
    async function loadVoices() {
        try {
            const response = await fetch('load_voices.php');
            const voices = await response.json();
            displayVoices(voices);
        } catch (error) {
            voiceList.innerHTML = '<p>Error loading voices. Please try again later.</p>';
            console.error('Error:', error);
        }
    }

    // Display voices in the UI
    function displayVoices(voices) {
        voiceList.innerHTML = '';
        if (!voices.length) {
            voiceList.innerHTML = '<p>No voice recordings found.</p>';
            return;
        }

        voices.forEach(voice => {
            const voiceItem = document.createElement('div');
            voiceItem.className = 'voice-item';
            voiceItem.innerHTML = `
                <h3>${voice.title}</h3>
                <p>${voice.description || 'No description provided.'}</p>
                <audio controls src="${voice.filepath}"></audio>
                <p class="timestamp">Uploaded on ${new Date(voice.uploaded_at).toLocaleString()}</p>
                ${voice.user_id === CURRENT_USER_ID ? `<button data-id="${voice.id}" class="delete-button">Delete</button>` : ''}
            `;
            voiceList.appendChild(voiceItem);
        });

        attachDeleteListeners();
    }

    // Search voices
    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.toLowerCase();
        const response = await fetch('load_voices.php');
        const voices = await response.json();
        const filtered = voices.filter(voice =>
            voice.title.toLowerCase().includes(query) ||
            (voice.description && voice.description.toLowerCase().includes(query))
        );
        displayVoices(filtered);
    });

    // Sort voices
    sortSelect.addEventListener('change', async () => {
        const sortBy = sortSelect.value;
        const response = await fetch('load_voices.php');
        const voices = await response.json();

        voices.sort((a, b) => {
            if (sortBy === 'newest') return new Date(b.uploaded_at) - new Date(a.uploaded_at);
            if (sortBy === 'oldest') return new Date(a.uploaded_at) - new Date(b.uploaded_at);
            if (sortBy === 'title') return a.title.localeCompare(b.title);
        });

        displayVoices(voices);
    });

    // Delete button functionality
    function attachDeleteListeners() {
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', async (e) => {
                const id = e.target.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this recording?')) {
                    const response = await fetch('delete_voice.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id })
                    });
                    const result = await response.text();
                    if (result === 'success') {
                        loadVoices();
                    } else {
                        alert('Failed to delete recording.');
                    }
                }
            });
        });
    }

    loadVoices(); // Initial load
});
