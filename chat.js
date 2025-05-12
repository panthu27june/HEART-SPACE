document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const clearChatButton = document.getElementById('clearChatButton');
    const newChatButton = document.getElementById('newChatButton');
    const chatHistoryList = document.getElementById('chatHistoryList');
    
    // Chat state
    let conversationId = null;
    let messages = [];
    let isTyping = false;
    
    // Initialize chat
    function initChat() {
        // Clear existing messages
        chatMessages.innerHTML = `
            <div class="message ai-message">
                <div class="message-avatar">
                    <svg class="heartspace-avatar" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="20" fill="#EE4B2B" />
                        <path d="M20 10 L26 18 L32 10 L30 24 L20 30 L10 24 L8 10 L14 18 Z" fill="#FFF5D7" />
                    </svg>
                </div>
                <div class="message-content">
                    <div class="message-sender">HeartSpace AI</div>
                    <div class="message-text">
                        <p>Hello! I'm the HeartSpace AI assistant. How are you feeling today? I'm here to chat, listen, or just keep you company.</p>
                    </div>
                </div>
            </div>
        `;
        
        // Reset messages array
        messages = [{
            role: 'system',
            content: 'You are HeartSpace AI, a compassionate and supportive AI assistant designed to provide emotional support and engage in meaningful conversations. Be warm, empathetic, and conversational. Respond with thoughtful, reflective answers that show you understand the user\'s feelings. You can discuss emotions, provide mindfulness tips, engage in creative expression, and have philosophical conversations. Keep responses concise (1-3 paragraphs) and conversational.'
        }, {
            role: 'assistant',
            content: 'Hello! I\'m the HeartSpace AI assistant. How are you feeling today? I\'m here to chat, listen, or just keep you company.'
        }];
        
        // Generate a new conversation ID
        conversationId = Date.now().toString();
        
        // Scroll to bottom
        scrollToBottom();
        
        // Reset message input
        messageInput.value = '';
        messageInput.focus();
    }
    
    // Add a message to the chat
    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = isUser ? 'message user-message' : 'message ai-message';
        
        // Create message HTML
        messageDiv.innerHTML = `
            <div class="message-avatar">
                ${isUser 
                    ? `<div class="user-avatar">${getUserInitial()}</div>`
                    : `<svg class="heartspace-avatar" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="20" fill="#EE4B2B" />
                        <path d="M20 10 L26 18 L32 10 L30 24 L20 30 L10 24 L8 10 L14 18 Z" fill="#FFF5D7" />
                      </svg>`
                }
            </div>
            <div class="message-content">
                <div class="message-sender">${isUser ? 'You' : 'HeartSpace AI'}</div>
                <div class="message-text">
                    ${formatMessageContent(message)}
                </div>
            </div>
        `;
        
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        if (isTyping) return;
        
        isTyping = true;
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message ai-message typing-indicator-container';
        typingDiv.id = 'typingIndicator';
        
        typingDiv.innerHTML = `
            <div class="message-avatar">
                <svg class="heartspace-avatar" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="#EE4B2B" />
                    <path d="M20 10 L26 18 L32 10 L30 24 L20 30 L10 24 L8 10 L14 18 Z" fill="#FFF5D7" />
                </svg>
            </div>
            <div class="message-content">
                <div class="typing-indicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>
        `;
        
        chatMessages.appendChild(typingDiv);
        scrollToBottom();
    }
    
    // Hide typing indicator
    function hideTypingIndicator() {
        if (!isTyping) return;
        
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
        isTyping = false;
    }
    
    // Get first letter of username for avatar
    function getUserInitial() {
        // Try to get username from session
        const usernameElement = document.querySelector('.register h2');
        if (usernameElement) {
            const username = usernameElement.textContent.trim().replace('Welcome, ', '');
            return username.charAt(0).toUpperCase();
        }
        return 'U'; // Default if username not found
    }
    
    // Format message content (simple text to HTML with paragraphs)
    function formatMessageContent(text) {
        if (!text) return '';
        
        // Split by double newlines to create paragraphs
        const paragraphs = text.split('\n\n');
        return paragraphs.map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
    }
    
    // Scroll chat to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Send message to AI
    function sendMessage(messageText) {
        if (!messageText.trim()) return;
        
        // Add user message to chat
        addMessage(messageText, true);
        
        // Add to messages array
        messages.push({
            role: 'user',
            content: messageText
        });
        
        // Show typing indicator
        showTypingIndicator();
        
        // Prepare data for API
        const data = {
            message: messageText,
            conversation_id: conversationId,
            messages: messages
        };
        
        // Send to server
        fetch('api/chat_ai.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            // Hide typing indicator
            hideTypingIndicator();
            
            if (data.success) {
                // Add AI response to chat
                addMessage(data.response);
                
                // Add to messages array
                messages.push({
                    role: 'assistant',
                    content: data.response
                });
                
                // Update chat history if user is logged in
                updateChatHistory();
            } else {
                throw new Error(data.message || 'Failed to get response');
            }
        })
        .catch(error => {
            console.error('Error communicating with AI:', error);
            hideTypingIndicator();
            
            // Show error message in chat
            const errorMessage = 'Sorry, I encountered an error while processing your message. Please try again.';
            addMessage(errorMessage);
        });
    }
    
    // Update chat history in sidebar (if user is logged in)
    function updateChatHistory() {
        if (!chatHistoryList) return;
        
        // Skip if chat history shows login prompt (user not logged in)
        if (chatHistoryList.querySelector('.login-prompt')) return;
        
        // Get first few words of first user message as title
        let chatTitle = 'New Conversation';
        
        for (let i = 0; i < messages.length; i++) {
            if (messages[i].role === 'user') {
                chatTitle = messages[i].content.substring(0, 30);
                if (messages[i].content.length > 30) chatTitle += '...';
                break;
            }
        }
        
        // Check if this conversation already exists in history
        let existingChat = document.querySelector(`.chat-history-item[data-id="${conversationId}"]`);
        
        if (existingChat) {
            // Update existing entry
            const titleEl = existingChat.querySelector('.chat-history-title');
            if (titleEl) titleEl.textContent = chatTitle;
        } else {
            // Create new history entry
            const historyItem = document.createElement('div');
            historyItem.className = 'chat-history-item active';
            historyItem.setAttribute('data-id', conversationId);
            
            const now = new Date();
            historyItem.innerHTML = `
                <div class="chat-history-title">${escapeHtml(chatTitle)}</div>
                <div class="chat-history-date">${now.toLocaleString()}</div>
            `;
            
            // Add click event to load this conversation
            historyItem.addEventListener('click', function() {
                // This is a simplified version - in a full implementation, 
                // we would load the conversation from server based on ID
                document.querySelectorAll('.chat-history-item').forEach(item => {
                    item.classList.remove('active');
                });
                historyItem.classList.add('active');
            });
            
            // Add to history list (at the beginning)
            if (chatHistoryList.firstChild) {
                chatHistoryList.insertBefore(historyItem, chatHistoryList.firstChild);
            } else {
                chatHistoryList.appendChild(historyItem);
            }
        }
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Event Listeners
    // Form submission
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message) {
                sendMessage(message);
                messageInput.value = '';
            }
        });
    }
    
    // Clear chat button
    if (clearChatButton) {
        clearChatButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to clear this conversation?')) {
                initChat();
            }
        });
    }
    
    // New chat button
    if (newChatButton) {
        newChatButton.addEventListener('click', function() {
            initChat();
            
            // Update active state in chat history
            document.querySelectorAll('.chat-history-item').forEach(item => {
                item.classList.remove('active');
            });
        });
    }
    
    // Auto-resize textarea
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            const newHeight = Math.min(this.scrollHeight, 150);
            this.style.height = newHeight + 'px';
        });
        
        // Allow Enter to submit, Shift+Enter for new line
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    }
    
    // Initialize chat on page load
    initChat();
    
    // Initialize Feather icons
    feather.replace();
});
