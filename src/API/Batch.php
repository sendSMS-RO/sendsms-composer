<?php

namespace SendSMS\API;

use ReflectionMethod;

class Batch extends ApiCommunication
{
    var $curl = false;
    /**
     *   Retrieves a list of the user batches.
     *
     *   @global string $username
     *   @global string $password
     */
    function batches_list()
    {
        $args = func_get_args();
        return $this->call_api_action(new ReflectionMethod(__CLASS__, __FUNCTION__), $args);
    }

    /**
     *   Checks the status of a batch
     *
     *   @global string $username
     *   @global string $password
     *   @param int $batch_id: The ID of the batch
     */
    function batch_check_status($batch_id)
    {
        $args = func_get_args();
        return $this->call_api_action(new ReflectionMethod(__CLASS__, __FUNCTION__), $args);
    }

    /**
     *   Creates a new batch
     *
     *   @global string $username
     *   @global string $password
     *   @param string $name: The name of the batch
     *   @param int $throughput (optional): Throughput to deliver this batch at
     *   @param boolean $filter (optional): Filter this batch against the global blocklist
     *   @param string $file_type (optional): The type of the file
     *   @param string $start_time (optional): The time when the batch will start
     */
    function batch_create($name, $file, $throughput = 0, $filter = false, $file_type = 'csv', $start_time = null)
    {
        if (function_exists('curl_init')) {
            if ($this->curl === FALSE) {
                $this->curl = curl_init();
            } else {
                curl_close($this->curl);
                $this->curl = curl_init();
            }

            if (!file_exists($file)) {
                $this->debug("File {$file} does not exist");
                return FALSE;
            }

            if ($file_type != 'zip') {
                $data = "data=" . urlencode(file_get_contents($file));
            } else {
                $data = "data=" . urlencode(base64_encode(file_get_contents($file)));
            }

            $url = $this->url;
            if (!is_null($this->password) && !is_null($this->username)) {
                $url .= "&username=" . urlencode($this->username);
                $url .= "&password=" . urlencode($this->password);
            } else {
                $this->debug("You need to specify your username and password using setUsername() and setPassword()");
                return false;
            }

            $url .= "?action=batch_create";
            $url .= "&name=" . urlencode($name);
            $url .= "&file_type=" . urlencode($file_type);
            $url .= "&filter=" . ($filter ? 'true' : 'false');
            $url .= "&throughput=" . $throughput;

            if (!is_null($start_time)) {
                $url .= "&start_time=" . urlencode($start_time);
            }

            curl_setopt($this->curl, CURLOPT_HEADER, 1);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Connection: keep-alive"));
            curl_setopt($this->curl, CURLOPT_POST, 1);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

            $result = curl_exec($this->curl);

            $size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
            $result = substr($result, $size);

            if ($result !== FALSE) {
                return json_decode($result, true);
            }
            return false;
        } else {
            $this->debug("You need cURL to use this API Library");
        }
    }

    /**
     *   Starts the given batch
     *
     *   @global string $username
     *   @global string $password
     *   @param int $batch_id: The ID of the batch
     */
    function batch_start($batch_id)
    {
        $args = func_get_args();
        return $this->call_api_action(new ReflectionMethod(__CLASS__, __FUNCTION__), $args);
    }

    /**
     *   Stops/pauses the given batch
     *
     *   @global string $username
     *   @global string $password
     *   @param int $batch_id: The ID of the batch
     */
    function batch_stop($batch_id)
    {
        $args = func_get_args();
        return $this->call_api_action(new ReflectionMethod(__CLASS__, __FUNCTION__), $args);
    }
}
