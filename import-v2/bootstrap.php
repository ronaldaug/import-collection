<?php

/**
 * CSV to Array
 *
 * @param  $file
 * @return array
 */
function csv_to_array($data)
{
    $csv = array_map(fn($line) => str_getcsv($line, ',', '"', '\\'), explode("\n", $data));
    array_walk($csv, function (&$row) use ($csv) {
        $row = array_combine($csv[0], $row);
    });
    array_shift($csv);
    return $csv;
}

function arrayCastRecursive($array)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = arrayCastRecursive($value);
            }
            if ($value instanceof stdClass) {
                $array[$key] = arrayCastRecursive((array)$value);
            }
        }
    }
    if ($array instanceof stdClass) {
        return arrayCastRecursive((array)$array);
    }
    return $array;
}

$this->bind('/api/import', function () {

    // Step 3 - Importing csv or json
    $file = $_FILES['entries'];
    $accept_type = ['text/csv', 'application/json'];

    if (!in_array($file['type'], $accept_type)) {
        return $this->stop(['error' => 'File type is not allowed!'], 401);
    }

    $data = file_get_contents($file['tmp_name']);

    $collection = $this->param('collection', null);
    $user_id    = $this->param('user_id', null);
    $publish    = $this->param('publish', null);
    
    if (!$collection || !$data || !$user_id || !$publish) {
        return $this->stop(['error' => 'Missing data!'], 401);
    }
    
    // make sure it's lowercase
    $collection = strtolower($collection);

    if ($file['type'] === 'text/csv') {
        $entries = csv_to_array($data);
    } else {
        $entries = arrayCastRecursive(json_decode($data));
    }

    if (!$this->module('content')->exists($collection)) {
        return $this->stop(['error' => 'Collection not found'], 412);
    }

    if (empty($entries)) {
        return $this->stop(['error' => 'No entries'], 412);
    }

    $user = $this->dataStorage->findOne('system/users', ['_id' => $user_id]);

    foreach ($entries as &$entry) {
        $entry = (array)$entry;
        $id    = isset($entry['_id']) ? $entry['_id'] : null;

        // Prevent not to overwrite existing id
        if (!$this->module('content')->item($collection, ['_id' => $id])) {

            unset($entry['_by']);
            unset($entry['_created']);
            unset($entry['_id']);
            unset($entry['_modified']);
            unset($entry['_mby']);

            if ($publish === '1') {
                $entry['_state'] = 1;
            }

            $this->module('content')->saveItem($collection, $entry, ['user' => $user]);
        }
    }

    return json_encode([
        'status' => 200,
        'message' => 'Successfully imported!'
    ]);
});
