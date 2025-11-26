/**
 * JavaScript para el chat del asistente virtual en WordPress
 */
(function($) {
    'use strict';
    
    // Variables globales
    let isRecording = false;
    let currentAudio = null;
    let currentAudioMessageDiv = null;
    let stopAudioButton = null;
    
    // Esperar a que el DOM esté listo
    $(document).ready(function() {
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const userInput = document.getElementById('userInput');
        const sendButton = document.getElementById('sendButton');
        const recordButton = document.getElementById('recordButton');
        const stopRecordingButton = document.getElementById('stopRecordingButton');
        const recordingStatus = document.getElementById('recordingStatus');
        
        if (!chatMessages || !chatForm || !userInput) {
            return; // No hay chat en esta página
        }
        
        // Función para convertir Markdown básico a HTML
        function markdownToHtml(markdown) {
            if (!markdown) return '';
            
            let html = markdown;
            const lines = html.split('\n');
            let result = [];
            let inList = false;
            let listItems = [];
            
            for (let i = 0; i < lines.length; i++) {
                const line = lines[i].trim();
                
                // Títulos
                if (line.startsWith('### ')) {
                    if (inList) {
                        result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
                        listItems = [];
                        inList = false;
                    }
                    result.push('<h3 style="font-size: 1.1em; font-weight: bold; margin-top: 16px; margin-bottom: 8px; color: #333;">' + line.substring(4) + '</h3>');
                } else if (line.startsWith('## ')) {
                    if (inList) {
                        result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
                        listItems = [];
                        inList = false;
                    }
                    result.push('<h2 style="font-size: 1.3em; font-weight: bold; margin-top: 20px; margin-bottom: 12px; color: #2c3e50;">' + line.substring(3) + '</h2>');
                } else if (line.startsWith('# ')) {
                    if (inList) {
                        result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
                        listItems = [];
                        inList = false;
                    }
                    result.push('<h1 style="font-size: 1.5em; font-weight: bold; margin-top: 24px; margin-bottom: 16px; color: #1a1a1a;">' + line.substring(2) + '</h1>');
                }
                // Listas con viñetas
                else if (line.startsWith('- ') || line.startsWith('* ')) {
                    if (!inList) inList = true;
                    const itemText = line.substring(2);
                    listItems.push('<li style="margin: 6px 0; padding-left: 8px;">' + formatInline(itemText) + '</li>');
                }
                // Listas numeradas
                else if (/^\d+\.\s/.test(line)) {
                    if (!inList) inList = true;
                    const itemText = line.replace(/^\d+\.\s/, '');
                    listItems.push('<li style="margin: 6px 0; padding-left: 8px;">' + formatInline(itemText) + '</li>');
                }
                // Línea vacía
                else if (line === '') {
                    if (inList) {
                        result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
                        listItems = [];
                        inList = false;
                    }
                    if (result.length > 0 && !result[result.length - 1].endsWith('</p>')) {
                        result.push('<br>');
                    }
                }
                // Párrafo normal
                else {
                    if (inList) {
                        result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
                        listItems = [];
                        inList = false;
                    }
                    result.push('<p style="margin: 12px 0; line-height: 1.6;">' + formatInline(line) + '</p>');
                }
            }
            
            // Cerrar lista si queda abierta
            if (inList) {
                result.push('<ul style="margin: 12px 0; padding-left: 24px; list-style-type: disc;">' + listItems.join('') + '</ul>');
            }
            
            return result.join('');
        }
        
        // Función auxiliar para formatear texto inline
        function formatInline(text) {
            let formatted = text;
            formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong style="font-weight: bold; color: #2c3e50;">$1</strong>');
            formatted = formatted.replace(/\*(.*?)\*/g, '<em>$1</em>');
            return formatted;
        }
        
        // Función para agregar mensaje al chat
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            const textDiv = document.createElement('div');
            textDiv.className = 'formatted-message';
            textDiv.style.cssText = 'line-height: 1.6;';
            if (isUser) {
                textDiv.textContent = message;
            } else {
                textDiv.innerHTML = markdownToHtml(message);
            }
            messageContent.appendChild(textDiv);
            
            // Si es mensaje del bot y el audio está habilitado, agregar controles
            if (!isUser && 'speechSynthesis' in window && asistenteVirtual.enableAudio) {
                const audioControlsDiv = document.createElement('div');
                audioControlsDiv.className = 'audio-controls';
                audioControlsDiv.style.marginTop = '8px';
                audioControlsDiv.style.display = 'flex';
                audioControlsDiv.style.alignItems = 'center';
                audioControlsDiv.style.gap = '8px';
                
                stopAudioButton = document.createElement('button');
                stopAudioButton.className = 'stop-audio-button';
                stopAudioButton.innerHTML = `
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                        <rect x="6" y="4" width="4" height="16" rx="1"></rect>
                        <rect x="14" y="4" width="4" height="16" rx="1"></rect>
                    </svg>
                `;
                stopAudioButton.title = 'Pausar audio';
                stopAudioButton.style.display = 'none';
                
                stopAudioButton.addEventListener('click', () => {
                    if (currentAudio) {
                        currentAudio.pause();
                        currentAudio.currentTime = 0;
                        currentAudio = null;
                    }
                    if (stopAudioButton) {
                        stopAudioButton.style.display = 'none';
                    }
                    currentAudioMessageDiv = null;
                });
                
                audioControlsDiv.appendChild(stopAudioButton);
                messageContent.appendChild(audioControlsDiv);
                currentAudioMessageDiv = messageDiv;
            }
            
            messageDiv.appendChild(messageContent);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Función para crear mensaje con cargador
        function createLoadingMessage() {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message bot-message';
            messageDiv.id = 'loadingMessage';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            const loaderDiv = document.createElement('div');
            loaderDiv.className = 'message-loader';
            loaderDiv.innerHTML = '<div class="loading-spinner"></div><span>Generando respuesta...</span>';
            messageContent.appendChild(loaderDiv);
            
            messageDiv.appendChild(messageContent);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            return messageDiv;
        }
        
        // Función para reemplazar cargador con mensaje
        function replaceLoaderWithMessage(messageDiv, messageText, stopBtn) {
            const messageContent = messageDiv.querySelector('.message-content');
            messageContent.innerHTML = '';
            
            const textDiv = document.createElement('div');
            textDiv.className = 'formatted-message';
            textDiv.style.cssText = 'line-height: 1.6; color: #333;';
            textDiv.innerHTML = markdownToHtml(messageText);
            messageContent.appendChild(textDiv);
            
            if ('speechSynthesis' in window && asistenteVirtual.enableAudio) {
                const audioControlsDiv = document.createElement('div');
                audioControlsDiv.className = 'audio-controls';
                audioControlsDiv.style.marginTop = '8px';
                audioControlsDiv.style.display = 'flex';
                audioControlsDiv.style.alignItems = 'center';
                audioControlsDiv.style.gap = '8px';
                
                stopAudioButton = stopBtn || document.createElement('button');
                stopAudioButton.className = 'stop-audio-button';
                stopAudioButton.innerHTML = `
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                        <rect x="6" y="4" width="4" height="16" rx="1"></rect>
                        <rect x="14" y="4" width="4" height="16" rx="1"></rect>
                    </svg>
                `;
                stopAudioButton.title = 'Pausar audio';
                stopAudioButton.style.display = 'none';
                
                stopAudioButton.addEventListener('click', () => {
                    if (currentAudio) {
                        currentAudio.pause();
                        currentAudio.currentTime = 0;
                        currentAudio = null;
                    }
                    if (stopAudioButton) {
                        stopAudioButton.style.display = 'none';
                    }
                    currentAudioMessageDiv = null;
                });
                
                audioControlsDiv.appendChild(stopAudioButton);
                messageContent.appendChild(audioControlsDiv);
                currentAudioMessageDiv = messageDiv;
            }
        }
        
        // Función para enviar mensaje al chat (AJAX)
        async function sendChatMessage(question) {
            userInput.disabled = true;
            sendButton.disabled = true;
            if (recordButton) recordButton.disabled = true;
            
            const loadingMessageDiv = createLoadingMessage();
            
            try {
                const response = await $.ajax({
                    url: asistenteVirtual.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'asistente_virtual_chat',
                        nonce: asistenteVirtual.nonce,
                        question: question
                    },
                    timeout: 60000
                });
                
                if (response.success) {
                    replaceLoaderWithMessage(loadingMessageDiv, response.data.answer, null);
                    
                    // Reproducir audio si está habilitado
                    if (asistenteVirtual.enableAudio && response.data.answer) {
                        // speakText se implementaría aquí si se necesita
                    }
                } else {
                    replaceLoaderWithMessage(loadingMessageDiv, 'Error: ' + (response.data.message || 'Algo salió mal'), null);
                }
            } catch (error) {
                replaceLoaderWithMessage(loadingMessageDiv, 'Error de conexión: ' + error.message, null);
            } finally {
                userInput.disabled = false;
                sendButton.disabled = false;
                if (recordButton) recordButton.disabled = false;
                userInput.focus();
            }
        }
        
        // Manejar envío del formulario
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const question = userInput.value.trim();
            if (!question) return;
            
            addMessage(question, true);
            userInput.value = '';
            
            sendChatMessage(question);
        });
        
        // Función para iniciar grabación de voz (Web Speech API)
        async function startRecording() {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert('Tu navegador no soporta reconocimiento de voz. Por favor, usa Chrome, Edge o Safari.');
                return;
            }
            
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            
            recognition.lang = 'es-CO';
            recognition.continuous = false;
            recognition.interimResults = true;
            recognition.maxAlternatives = 3;
            
            if (recordButton) recordButton.style.display = 'none';
            if (recordingStatus) recordingStatus.style.display = 'flex';
            userInput.disabled = true;
            sendButton.disabled = true;
            
            let finalTranscript = '';
            
            recognition.onstart = () => {
                isRecording = true;
                finalTranscript = '';
            };
            
            recognition.onresult = (event) => {
                let interim = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalTranscript += transcript + ' ';
                    } else {
                        interim += transcript + ' ';
                    }
                }
            };
            
            recognition.onend = () => {
                if (finalTranscript.trim()) {
                    addMessage(finalTranscript.trim(), true);
                    sendChatMessage(finalTranscript.trim());
                }
                stopRecording();
            };
            
            recognition.onerror = (event) => {
                console.error('Error en reconocimiento de voz:', event.error);
                stopRecording();
            };
            
            try {
                recognition.start();
                window.currentRecognition = recognition;
            } catch (error) {
                console.error('Error al iniciar reconocimiento:', error);
                stopRecording();
            }
        }
        
        // Función para detener grabación
        function stopRecording() {
            if (window.currentRecognition && isRecording) {
                try {
                    window.currentRecognition.stop();
                } catch (e) {
                    console.log('El reconocimiento ya estaba detenido');
                }
            }
            isRecording = false;
            if (recordButton) recordButton.style.display = 'flex';
            if (recordingStatus) recordingStatus.style.display = 'none';
            userInput.disabled = false;
            sendButton.disabled = false;
            userInput.focus();
        }
        
        // Event listeners para grabación
        if (recordButton) {
            recordButton.addEventListener('click', startRecording);
        }
        if (stopRecordingButton) {
            stopRecordingButton.addEventListener('click', stopRecording);
        }
        
        // Focus automático en el input
        userInput.focus();
    });
    
})(jQuery);

