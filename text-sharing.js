document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const textForm = document.getElementById('textShareForm');
    const textContent = document.getElementById('textContent');
    const charCounter = document.getElementById('charCounter');
    const shareButton = document.getElementById('shareTextButton');
    const textList = document.getElementById('textList');
    const searchInput = document.getElementById('searchText');
    const sortSelect = document.getElementById('sortText');
    
    // Update character counter
    if (textContent && charCounter) {
        textContent.addEventListener('input', function() {
            const count = textContent.value.length;
            charCounter.textContent = `${count} characters`;
            
            // Optional: Visual indication for long texts
            if (count > 1000) {
                charCounter.classList.add('char-count-high');
            } else {
                charCounter.classList.remove('char-count-high');
            }
        });
    }
    
    // Handle form submission
    if (textForm) {
        textForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('textTitle').value;
            const content = textContent.value;
            
            if (!title) {
                alert('Please enter a title for your text.');
                return;
            }
            
            if (!content) {
                alert('Please enter some content to share.');
                return;
            }
            
            // Show loading state
            shareButton.disabled = true;
            shareButton.textContent = 'Sharing...';
            
            // Prepare data
            const formData = new FormData();
            formData.append('title', title);
            formData.append('content', content);
            
            // Submit to server
            fetch('api/share_text.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Your text has been shared successfully!');
                    
                    // Reset form
                    textForm.reset();
                    charCounter.textContent = '0 characters';
                    
                    // Refresh text list
                    loadTextShares();
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error sharing text:', error);
                alert('Error sharing text: ' + error.message);
            })
            .finally(() => {
                shareButton.disabled = false;
                shareButton.textContent = 'Share';
            });
        });
    }
    
    // Load text shares on page load
    loadTextShares();
    
    // Set up event listeners for search and sort
    if (searchInput) {
        searchInput.addEventListener('input', debounce(loadTextShares, 300));
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', loadTextShares);
    }
});

// Function to load text shares from server
function loadTextShares() {
    const textList = document.getElementById('textList');
    const searchInput = document.getElementById('searchText');
    const sortSelect = document.getElementById('sortText');
    
    if (!textList) return;
    
    textList.innerHTML = '<div class="loading">Loading shared texts...</div>';
    
    // Get filter values
    const searchTerm = searchInput ? searchInput.value : '';
    const sortBy = sortSelect ? sortSelect.value : 'newest';
    
    // Fetch texts from server
    fetch(`api/get_texts.php?search=${encodeURIComponent(searchTerm)}&sort=${sortBy}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.texts.length === 0) {
                    textList.innerHTML = '<div class="no-results">No text shares found</div>';
                    return;
                }
                
                textList.innerHTML = '';
                
                data.texts.forEach(text => {
                    const textDate = new Date(text.created_at);
                    const formattedDate = textDate.toLocaleString();
                    
                    // Format content with simple markdown
                    const formattedContent = formatContent(text.content);
                    
                    const textElement = document.createElement('div');
                    textElement.className = 'text-item';
                    textElement.innerHTML = `
                        <div class="text-item-header">
                            <h3 class="text-item-title">${escapeHtml(text.title)}</h3>
                            <span class="text-item-time">${formattedDate}</span>
                        </div>
                        <div class="text-item-content">${formattedContent}</div>
                        <p class="text-item-user">Shared by: ${escapeHtml(text.username)}</p>
                    `;
                    
                    textList.appendChild(textElement);
                });
            } else {
                textList.innerHTML = `<div class="error-message">Error: ${data.message || 'Unknown error'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error fetching text shares:', error);
            textList.innerHTML = `<div class="error-message">Failed to load texts. Please try again later.</div>`;
        });
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Simple markdown formatter
function formatContent(content) {
    if (!content) return '';
    
    // Escape HTML first
    let formatted = escapeHtml(content);
    
    // Convert line breaks to paragraphs
    formatted = formatted.split('\n\n').map(para => `<p>${para}</p>`).join('');
    
    // Handle single line breaks
    formatted = formatted.replace(/\n/g, '<br>');
    
    // Simple markdown
    // Bold
    formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    
    // Italic
    formatted = formatted.replace(/\*(.*?)\*/g, '<em>$1</em>');
    
    // Blockquotes
    formatted = formatted.replace(/<p>&gt; (.*?)<\/p>/g, '<blockquote>$1</blockquote>');
    formatted = formatted.replace(/&gt; (.*?)<br>/g, '<blockquote>$1</blockquote>');
    
    return formatted;
}

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
