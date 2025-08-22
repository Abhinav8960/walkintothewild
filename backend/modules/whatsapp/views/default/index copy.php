
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
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-emoji-smile"></i>
                        </button>
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-paperclip"></i>
                        </button>
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

<!-- Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<!-- JavaScript for WhatsApp Panel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample data for contacts
        const contacts = [{
                id: 1,
                name: "John Doe",
                image: "https://via.placeholder.com/45",
                lastMessage: "Hey, how are you?",
                time: "10:30 AM",
                status: "online"
            },
            {
                id: 2,
                name: "Jane Smith",
                image: "https://via.placeholder.com/45",
                lastMessage: "Meeting at 2 PM",
                time: "9:45 AM",
                status: "offline"
            }
            // Add more contacts as needed
        ];

        // Load contacts
        function loadContacts() {
            const contactsList = document.getElementById('contactsList');
            contactsList.innerHTML = contacts.map(contact => `
            <div class="contact-item p-3 border-bottom" data-id="${contact.id}">
                <div class="d-flex align-items-center">
                    <img src="${contact.image}" alt="${contact.name}" class="profile-image me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">${contact.name}</h6>
                            <small class="text-muted">${contact.time}</small>
                        </div>
                        <p class="mb-0 last-message">${contact.lastMessage}</p>
                    </div>
                </div>
            </div>
        `).join('');

            // Add click event to contacts
            document.querySelectorAll('.contact-item').forEach(item => {
                item.addEventListener('click', () => {
                    // Remove active class from all contacts
                    document.querySelectorAll('.contact-item').forEach(contact => {
                        contact.classList.remove('active');
                    });
                    // Add active class to clicked contact
                    item.classList.add('active');

                    // Load chat for selected contact
                    const contactId = item.dataset.id;
                    loadChat(contactId);
                });
            });
        }

        // Load chat messages
        function loadChat(contactId) {
            const contact = contacts.find(c => c.id == contactId);
            if (!contact) return;

            // Update chat header
            document.getElementById('currentContactName').textContent = contact.name;
            document.getElementById('currentContactStatus').textContent = contact.status;

            // Sample messages - in real application, these would come from your backend
            const messages = [{
                    text: "Hi there!",
                    type: "received",
                    time: "10:00 AM"
                },
                {
                    text: "Hello! How can I help you?",
                    type: "sent",
                    time: "10:01 AM"
                },
                {
                    text: "I need information about your services.",
                    type: "received",
                    time: "10:02 AM"
                }
            ];

            // Display messages
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = messages.map(message => `
            <div class="message message-${message.type}">
                ${message.text}
                <div class="message-time">${message.time}</div>
            </div>
        `).join('');

            // Scroll to bottom of messages
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Send message function
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message) {
                const messagesContainer = document.getElementById('messagesContainer');
                const currentTime = new Date().toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageElement = document.createElement('div');
                messageElement.className = 'message message-sent';
                messageElement.innerHTML = `
                ${message}
                <div class="message-time">${currentTime}</div>
            `;

                messagesContainer.appendChild(messageElement);
                messageInput.value = '';

                // Scroll to bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }

        // Event listeners
        document.getElementById('sendMessage').addEventListener('click', sendMessage);
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Search contacts functionality
        document.getElementById('searchContacts').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.contact-item').forEach(item => {
                const name = item.querySelector('h6').textContent.toLowerCase();
                item.style.display = name.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Initial load
        loadContacts();
    });
</script>