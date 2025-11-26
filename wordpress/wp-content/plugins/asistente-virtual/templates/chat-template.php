<div class="asistente-virtual-chat-container">
    <div class="chat-container">
        <div class="chat-header">
            <div class="header-content">
                <div>
                    <h1><?php echo esc_html($atts['title']); ?></h1>
                    <p><?php echo esc_html($atts['subtitle']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-content">
                    ¡Hola! Soy tu mentor comercial. Pregúntame lo que necesites saber.
                </div>
            </div>
        </div>
        
        <div class="chat-input-container">
            <form id="chatForm">
                <input 
                    type="text" 
                    id="userInput" 
                    placeholder="Escribe tu pregunta aquí..." 
                    autocomplete="off"
                >
                <button type="button" id="recordButton" class="record-button" title="Grabar audio">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                        <line x1="12" y1="19" x2="12" y2="23"/>
                        <line x1="8" y1="23" x2="16" y2="23"/>
                    </svg>
                </button>
                <button type="submit" id="sendButton">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </form>
            <div id="recordingStatus" class="recording-status" style="display: none;">
                <span class="recording-dot"></span>
                <span>Grabando...</span>
                <button id="stopRecordingButton" class="stop-recording-button">Detener</button>
            </div>
        </div>
    </div>
</div>

