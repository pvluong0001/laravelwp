<?php

namespace App\Services;

class Socket
{
    public function open($host = '', $port = 80, $headers = '', &$error_string = '', $timeout = 10, $ssl = false, $persistant = false, $path = '/')
    {

        // Generate a key (to convince server that the update is not random)
        // The key is for the server to prove it i websocket aware. (We know it is)
        $key = base64_encode(openssl_random_pseudo_bytes(16));

        $header = "GET " . $path . " HTTP/1.1\r\n"
            . "Host: $host\r\n"
            . "pragma: no-cache\r\n"
            . "Upgrade: WebSocket\r\n"
            . "Connection: Upgrade\r\n"
            . "Sec-WebSocket-Key: $key\r\n"
            . "Sec-WebSocket-Version: 13\r\n";

        // Add extra headers
        if (!empty($headers)) foreach ($headers as $h) $header .= $h . "\r\n";

        // Add end of header marker
        $header .= "\r\n";

        // Connect to server
        $host = $host ? $host : "127.0.0.1";
        $port = $port < 1 ? 80 : $port;
        $address = ($ssl ? 'ssl://' : '') . $host . ':' . $port;
        // put in persistant ! if used in php-fpm, no handshare if same.
        if ($persistant)
            $sp = stream_socket_client($address, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT);
        else
            $sp = stream_socket_client($address, $errno, $errstr, $timeout);

        if (!$sp) {
            $error_string = "Unable to connect to websocket server: $errstr ($errno)";
            return false;
        }

        // Set timeouts
        stream_set_timeout($sp, $timeout);

        if (!$persistant or ftell($sp) === 0) {

            //Request upgrade to websocket
            $rc = fwrite($sp, $header);
            if (!$rc) {
                $error_string
                    = "Unable to send upgrade header to websocket server: $errstr ($errno)";
                return false;
            }

            // Read response into an assotiative array of headers. Fails if upgrade failes.
            $reaponse_header = fread($sp, 1024);

            // status code 101 indicates that the WebSocket handshake has completed.
            if (stripos($reaponse_header, ' 101 ') === false
                || stripos($reaponse_header, 'Sec-WebSocket-Accept: ') === false) {
                $error_string = "Server did not accept to upgrade connection to websocket."
                    . $reaponse_header . E_USER_ERROR;
                return false;
            }
            // The key we send is returned, concatenate with "258EAFA5-E914-47DA-95CA-
            // C5AB0DC85B11" and then base64-encoded. one can verify if one feels the need...

        }
        return $sp;
    }

    /*============================================================================*\
      Write to websocket
      int websocket_write(resource $handle, string $data ,[boolean $final])
      Write a chunk of data through the websocket, using hybi10 frame encoding
      handle
        the resource handle returned by websocket_open, if successful
      data
        Data to transport to server
      final (optional)
        indicate if this block is the final data block of this request. Default true
    \*============================================================================*/
    public function write($sp, $data, $final = true)
    {
        // Assamble header: FINal 0x80 | Opcode 0x02
        $header = chr(($final ? 0x80 : 0) | 0x02); // 0x02 binary

        // Mask 0x80 | payload length (0-125)
        if (strlen($data) < 126) $header .= chr(0x80 | strlen($data));
        elseif (strlen($data) < 0xFFFF) $header .= chr(0x80 | 126) . pack("n", strlen($data));
        else $header .= chr(0x80 | 127) . pack("N", 0) . pack("N", strlen($data));

        // Add mask
        $mask = pack("N", rand(1, 0x7FFFFFFF));
        $header .= $mask;

        // Mask application data.
        for ($i = 0; $i < strlen($data); $i++)
            $data[$i] = chr(ord($data[$i]) ^ ord($mask[$i % 4]));

        return fwrite($sp, $header . $data);
    }

    public function close($sp) {
        if($sp) {
            fclose($sp);
        }
    }
}
