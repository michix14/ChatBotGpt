<?php
//enviar.php
/*
 * RECIBIMOS LA RESPUESTA
*/
function enviar($recibido, $enviado, $idWA,$timestamp,$telefonoCliente) {
    require_once './conexion.php';
    //CONSULTAMOS TODOS LOS REGISTROS CON EL ID DEL MANSAJE
    $sqlCantidad = "SELECT count(id) AS cantidad FROM registro WHERE id_wa='" . $idWA . "';";
    $resultCantidad = $conn->query($sqlCantidad);
    //OBTENEMOS LA CANTIDAD DE MENSAJES ENCONTRADOS (SI ES 0 LO REGISTRAMOS SI NO NO)
    $cantidad = 0;
    //SI LA CONSULTA ARROJA RESULTADOS
    if ($resultCantidad) {
        //OBTENEMOS EL PRIMER REGISTRO
        $rowCantidad = $resultCantidad->fetch_row();
        //OBTENEMOS LA CANTIDAD DE REGISTROS
        $cantidad = $rowCantidad[0];
    }
    //SI LA CANTIDAD DE REGISTROS ES 0 ENVIAMOS EL MENSAJE DE LO CONTRARIO NO LO ENVIAMOS PORQUE YA SE ENVIO
    if ($cantidad == 0) {
        $enviado=str_replace("\n","",$enviado);
        //TOKEN QUE NOS DA FACEBOOK
        $token = 'EAAO3liKXi6IBOydaOYnnLxfzb21tLn0U49jvfgXTI2oYl9r9MhGZCLLSigI86ZCONuVVVexx8HgjT63Lxxs8Yj43ZAKMxwFIbE6oy0k35JTGYLLkkxNsJxMcJq2qVtG5bozGwxG4dIKT4D4uQjcZB0gUZAxIs01VOZCSx7Ve1uy2PytdOdVWWcgrKoIxVNnZCpq';
        //NUESTRO TELEFONO
        $telefonoCliente=str_replace("591","591",$telefonoCliente);
        //IDENTIFICADOR DE NÚMERO DE TELÉFONO
        $telefonoID = '152631287940890';
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = 'https://graph.facebook.com/v16.0/' . $telefonoID . '/messages';
        //CONFIGURACION DEL MENSAJE
        $mensaje = ''
                . '{'
                . '"messaging_product": "whatsapp", '
                . '"recipient_type": "individual",'
                . '"to": "' . $telefonoCliente . '", '
                . '"type": "text", '
                . '"text": '
                . '{'
                . '     "body":"' . $enviado . '",'
                . '     "preview_url": true, '
                . '} '
                . '}';
        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);
        //$enviado= trim($enviado,"\n");
        $enviado = [];
        //INSERTAMOS LOS REGISTROS DEL ENVIO DEL WHATSAPP
        $sql = "INSERT INTO registro "
            . "(mensaje_recibido    ,mensaje_enviado   ,id_wa        ,timestamp_wa        ,     telefono_wa) VALUES "
            . "('" . $recibido . "' ,'" . $enviado . "','" . $idWA . "','" . $timestamp . "','" . $telefonoCliente . "');";
        $conn->query($sql);
        $conn->close();
        //Aqui se guarda el mensaje recibido en el .txt
        $archivo = 'mensajes.txt';
        $nuevoMensaje = "Recibido: $recibido, ID WA: $idWA, Timestamp: $timestamp, Teléfono: $telefonoCliente\n";
        // Abre el archivo en modo de escritura (si no existe, lo crea)
        $file = fopen($archivo, 'a');
        if ($file) {
            // Escribe el nuevo mensaje en una nueva línea
            fwrite($file, $nuevoMensaje);
            // Cierra el archivo
            fclose($file);
        } else {
            // Manejar el error si no se puede abrir el archivo
            echo "Error al abrir el archivo $archivo";
        }
    }
}