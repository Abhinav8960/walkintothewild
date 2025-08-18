<?php

use support\assets\WhatsappAsset;
/* @var $this yii\web\View */

$this->title = 'WhatsApp Panel';
WhatsappAsset::register($this);
?>

<!-- Main Container -->
<div class="container-fluid mt-4">
    <div class="row chat-container shadow-sm rounded">
        <!-- Contacts List -->
        <div class="col-md-4 col-lg-3 p-0 chat-list">
            <div class="p-3 bg-white">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search contacts..." id="searchContacts">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div id="contactsList">
                <!-- Contacts will be loaded here dynamically -->
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 col-lg-9 p-0">
            <!-- Chat Placeholder -->
            <div id="chatPlaceholder" class="chat-placeholder">
                <div class="chat-placeholder-content">
                    <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Select a contact to start messaging</h4>
                </div>
            </div>

            <!-- Chat Box (Initially Hidden) -->
            <div id="chatbox" style="display: none;">
                <div class="chat-messages">
                    <!-- Chat Header -->
                    <div class="p-3 bg-white border-bottom" id="chatHeader">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/45" alt="Profile" class="profile-image me-3">
                            <div>
                                <h6 class="mb-0" id="currentContactName">Select a contact</h6>
                                <small class="text-muted" id="currentContactStatus">offline</small>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container" id="messagesContainer">
                        <!-- Messages will be loaded here dynamically -->
                    </div>

                    <!-- Chat Input -->
                    <div class="chat-input">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type a message" id="messageInput">
                            <button class="btn btn-primary" type="button" id="sendMessage">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<!-- JavaScript for WhatsApp Panel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbox = document.getElementById('chatbox');
        const chatPlaceholder = document.getElementById('chatPlaceholder');
        let currentContactId = null;

        function renderContacts(contacts) {
            const contactsList = document.getElementById('contactsList');
            contactsList.innerHTML = contacts.map(contact => `
                <div class="contact-item p-3 border-bottom" data-id="${contact.id}" data-name="${contact.name}" data-phone="${contact.phone_number}">
                    <div class="d-flex align-items-center">
                        <img src="${contact.profile_pic_url || 'https://via.placeholder.com/45'}" alt="Profile" class="profile-image me-3">
                        <div>
                            <h6 class="mb-0">${contact.name}</h6>
                            <small class="text-muted">${contact.phone_number}</small>
                        </div>
                    </div>
                </div>
            `).join('');

            // Add click event listeners to contacts
            document.querySelectorAll('.contact-item').forEach(item => {
                item.addEventListener('click', function() {
                    const contactId = this.dataset.id;
                    const contactName = this.dataset.name;

                    // Remove active class from all contacts
                    document.querySelectorAll('.contact-item').forEach(el =>
                        el.classList.remove('active'));

                    // Add active class to clicked contact
                    this.classList.add('active');

                    // Show chat and load messages
                    showChat(contactId, contactName);
                });
            });
        }

        function showChat(contactId, contactName) {
            // Hide placeholder and show chatbox
            chatPlaceholder.style.display = 'none';
            chatbox.style.display = 'block';

            // Update contact info in header
            document.getElementById('currentContactName').textContent = contactName;
            document.getElementById('currentContactStatus').textContent = 'online';

            // Update current contact ID
            currentContactId = contactId;

            // Clear previous messages and load new ones
            document.getElementById('messagesContainer').innerHTML = '';
            loadChat(contactId);
        }

        function loadChat(contactId) {
            fetch(`/whatsapp/default/get-messages?contactId=${contactId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderMessages(data.messages);
                    }
                })
                .catch(error => console.error('Error loading messages:', error));
        }

        function renderMessages(messages) {
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = messages.map(message => `
                <div class="message ${message.direction === 'outbound' ? 'message-sent' : 'message-received'}">
                    <div class="message-content">${message.content}</div>
                    <small class="message-time">${formatMessageTime(message.created_at)}</small>
                </div>
            `).join('');

            // Scroll to bottom of messages
            scrollToBottom();
        }

        function formatMessageTime(timestamp) {
            return new Date(timestamp).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function scrollToBottom() {
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message && currentContactId) {
                fetch('/whatsapp/default/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        },
                        body: JSON.stringify({
                            contact_id: currentContactId,
                            message: message,
                            type: 'text'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Add message to UI immediately
                            const messagesContainer = document.getElementById('messagesContainer');
                            const messageElement = document.createElement('div');
                            messageElement.className = 'message message-sent';
                            messageElement.innerHTML = `
                            <div class="message-content">${message}</div>
                            <small class="message-time">${formatMessageTime(new Date())}</small>
                        `;
                            messagesContainer.appendChild(messageElement);

                            // Clear input and scroll to bottom
                            messageInput.value = '';
                            scrollToBottom();
                        } else {
                            alert(data.error || 'Failed to send message');
                        }
                    })
                    .catch(error => console.error('Error sending message:', error));
            }
        }

        // Event Listeners
        document.getElementById('sendMessage').addEventListener('click', sendMessage);
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        document.getElementById('searchContacts').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.contact-item').forEach(item => {
                const name = item.querySelector('h6').textContent.toLowerCase();
                const phone = item.dataset.phone.toLowerCase();
                item.style.display = (name.includes(searchTerm) || phone.includes(searchTerm)) ? 'block' : 'none';
            });
        });

        // Function to load contacts from the server
        function loadContacts() {
            // Show loading state if needed
            const contactsList = document.getElementById('contactsList');
            contactsList.innerHTML = '<div class="p-3 text-center">Loading contacts...</div>';

            fetch('/whatsapp/default/get-contacts', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && Array.isArray(data.contacts)) {
                        if (data.contacts.length === 0) {
                            contactsList.innerHTML = '<div class="p-3 text-center">No contacts found</div>';
                        } else {
                            renderContacts(data.contacts);
                        }
                    } else {
                        throw new Error('Invalid data format received');
                    }
                })
                .catch(error => {
                    console.error('Error loading contacts:', error);
                    contactsList.innerHTML = `
                    <div class="p-3 text-center text-danger">
                        Error loading contacts. Please try again.
                    </div>`;
                });
        }

        // Initial load of contacts
        loadContacts();
    });
</script>