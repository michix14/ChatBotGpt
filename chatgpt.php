<?php
function preguntaChatgpt($pregunta){
    // API KEY DE CHATGPT
    $apiKey = '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';
    
    // INICIAMOS LA CONSULTA DE CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);

    // INICIAMOS EL JSON QUE SE ENVIARA A AI
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{
        "model": "text-davinci-003",
        "prompt": "' . $pregunta . '",
        "max_tokens": 4000,
        "temperature": 0.8
    }');

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // OBTENEMOS EL JSON COMPLETO CON LA RESPUESTA
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Obtener el código de respuesta HTTP
    curl_close($ch);

    // Verificar si la solicitud fue exitosa (código de respuesta 200)
    if ($httpCode != 200) {
        return 'Error en la solicitud. Código de respuesta: ' . $httpCode;
    }

    // DECODIFICAMOS EL JSON
    $decoded_json = json_decode($response);

    // VERIFICAMOS SI EL OBJETO NO ES NULO Y LA PROPIEDAD CHOICES ESTÁ DEFINIDA
    if ($decoded_json && isset($decoded_json->choices) && !empty($decoded_json->choices)) {
        // RETORNAMOS LA RESPUESTA QUE EXTRAEMOS DEL JSON
        return $decoded_json->choices[0]->text;
    } else {
        // MANEJAR EL CASO EN QUE NO HAYA RESPUESTA VÁLIDA
        return 'No se pudo obtener una respuesta válida. Respuesta completa: ' . $response;
    }
}

// EJEMPLO DE USO
$respuesta = preguntaChatgpt('Cuales son los frameworks de java');
echo $respuesta;
