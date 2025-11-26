<?php
/**
 * Maneja las peticiones AJAX y comunicación con Flask
 */
class Asistente_Virtual_API_Handler {
    
    /**
     * Maneja peticiones de chat
     */
    public function handle_chat_request() {
        // Verificar nonce
        check_ajax_referer('asistente_virtual_nonce', 'nonce');
        
        $question = isset($_POST['question']) ? sanitize_text_field($_POST['question']) : '';
        
        if (empty($question)) {
            wp_send_json_error(array('message' => 'La pregunta está vacía'));
            return;
        }
        
        // Obtener configuración
        $flask_url = get_option('asistente_virtual_flask_url', 'http://localhost:5001');
        $api_token = get_option('asistente_virtual_api_token', '');
        
        // Obtener historial de sesión (usar transients de WordPress)
        $session_id = $this->get_session_id();
        $history = get_transient('asistente_virtual_history_' . $session_id);
        if (!$history) {
            $history = array();
        }
        
        // Preparar petición a Flask
        $request_data = array(
            'question' => $question,
            'history' => $history,
            'session_id' => $session_id,
        );
        
        // Hacer petición a Flask API (sin autenticación)
        $headers = array(
            'Content-Type' => 'application/json',
        );
        
        // Solo agregar token si está configurado (opcional)
        if (!empty($api_token)) {
            $headers['Authorization'] = 'Bearer ' . $api_token;
        }
        
        $response = wp_remote_post($flask_url . '/api/chat', array(
            'timeout' => 60,
            'headers' => $headers,
            'body' => json_encode($request_data),
        ));
        
        if (is_wp_error($response)) {
            wp_send_json_error(array(
                'message' => 'Error de conexión con el servidor: ' . $response->get_error_message()
            ));
            return;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (wp_remote_retrieve_response_code($response) !== 200) {
            wp_send_json_error(array(
                'message' => isset($data['error']) ? $data['error'] : 'Error al procesar la pregunta'
            ));
            return;
        }
        
        // Actualizar historial desde la respuesta (si viene)
        if (isset($data['history']) && is_array($data['history'])) {
            $history = $data['history'];
        } else {
            // Fallback: construir historial manualmente
            $history[] = array('role' => 'user', 'content' => $question);
            $history[] = array('role' => 'assistant', 'content' => $data['answer']);
        }
        
        // Mantener solo los últimos 12 mensajes
        if (count($history) > 12) {
            $history = array_slice($history, -12);
        }
        
        // Guardar historial en transient (expira en 2 horas)
        set_transient('asistente_virtual_history_' . $session_id, $history, 2 * HOUR_IN_SECONDS);
        
        wp_send_json_success(array(
            'answer' => $data['answer']
        ));
    }
    
    /**
     * Maneja peticiones de text-to-speech
     */
    public function handle_tts_request() {
        // Verificar nonce
        check_ajax_referer('asistente_virtual_nonce', 'nonce');
        
        $text = isset($_POST['text']) ? sanitize_textarea_field($_POST['text']) : '';
        
        if (empty($text)) {
            wp_send_json_error(array('message' => 'El texto está vacío'));
            return;
        }
        
        // Obtener configuración
        $flask_url = get_option('asistente_virtual_flask_url', 'http://localhost:5001');
        $api_token = get_option('asistente_virtual_api_token', '');
        
        // Hacer petición a Flask API para TTS (sin autenticación)
        $headers = array(
            'Content-Type' => 'application/json',
        );
        
        // Solo agregar token si está configurado (opcional)
        if (!empty($api_token)) {
            $headers['Authorization'] = 'Bearer ' . $api_token;
        }
        
        $response = wp_remote_post($flask_url . '/api/tts', array(
            'timeout' => 60,
            'headers' => $headers,
            'body' => json_encode(array('text' => $text)),
        ));
        
        if (is_wp_error($response)) {
            wp_send_json_error(array(
                'message' => 'Error de conexión con el servidor: ' . $response->get_error_message()
            ));
            return;
        }
        
        $code = wp_remote_retrieve_response_code($response);
        
        if ($code === 200) {
            // Retornar el audio como respuesta binaria
            $audio_data = wp_remote_retrieve_body($response);
            header('Content-Type: audio/mpeg');
            header('Content-Disposition: inline; filename=audio.mp3');
            echo $audio_data;
            exit;
        } else {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            wp_send_json_error(array(
                'message' => isset($data['error']) ? $data['error'] : 'Error al generar audio'
            ));
        }
    }
    
    /**
     * Obtiene o crea un ID de sesión único
     */
    private function get_session_id() {
        if (!isset($_COOKIE['asistente_virtual_session'])) {
            $session_id = wp_generate_password(32, false);
            setcookie('asistente_virtual_session', $session_id, time() + (2 * HOUR_IN_SECONDS), '/');
            return $session_id;
        }
        return sanitize_text_field($_COOKIE['asistente_virtual_session']);
    }
}

