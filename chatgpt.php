<?php
function preguntaChatgpt($pregunta)
{
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
    $mensaje = "Realiza un analisis del siguiente mensaje y devuelve la palabra producto si el mensaje contiene o habla desq algun producto y sino entonces responde con la palabra otro, sin incluir un texto extra: . " . $pregunta . " ";
    $postFields = array(
        "model" => "text-davinci-003",
        "prompt" => $mensaje,
        "max_tokens" => 10,
        "temperature" => 1.0
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));


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
//$respuesta = preguntaChatgpt('Cuales son los frameworks de java');
//echo $respuesta;
function preguntaProductoChatgpt($pregunta)
{
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
    $mensaje = "Realiza un analisis del siguiente mensaje y devuelveme los productos de los que menciona el mensaje, cada producto de tu respuesta tiene que estar separado por una coma . " . $pregunta . " ";
    $postFields = array(
        "model" => "text-davinci-003",
        "prompt" => $mensaje,
        "max_tokens" => 10,
        "temperature" => 1.0
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));


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
function preguntaSentimientoChatgpt($pregunta)
{
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
    $mensaje = "Realiza un analisis de sentimientos del siguiente mensaje y devuelveme una cadena que solo diga si es positivo, neutro o negativo. No muestres el contenido del mensaje . " . $pregunta . " ";
    $postFields = array(
        "model" => "text-davinci-003",
        "prompt" => $mensaje,
        "max_tokens" => 10,
        "temperature" => 1.0
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));


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
