<?php

/**
 * CSV to Array
 *
 * @param  $file
 * @return array
 */
function csv_to_array($data)
{
    $csv = array_map('str_getcsv', explode("\n", $data));
    array_walk($csv, function (&$row) use ($csv) {
        $row = array_combine($csv[0], $row);
    });
    array_shift($csv);
    return $csv;
}

if (COCKPIT_API_REQUEST) {
    $app->on('cockpit.rest.init', function ($routes) use ($app) {
        $routes['import'] = function () use ($app) {

            $file = $_FILES['entries'];
            $accept_type = ['text/csv', 'application/json'];

            if (!in_array($file['type'], $accept_type)) {
                return $this->stop(['error' => 'File type is not allowed!'], 401);
            }

            $data = file_get_contents($file['tmp_name']);
    
            $collection = $this->param('collection', null);
    
            if (!$collection || !$data) {
                return $this->stop(['error' => 'Missing data!'], 401);
            }


            if ($file['type'] === 'text/csv') {
                $entries = csv_to_array($data);
            } else {
                $entries = json_decode($data);
            }

            if (!$this->module('collections')->exists($collection)) {
                return $this->stop(['error' => 'Collection not found'], 412);
            }
           
            if (!$this->module('collections')->hasaccess($collection, 'entries_create')) {
                return $this->stop(['error' => 'Unauthorized'], 401);
            }

            $_collection = $this->module('collections')->collection($collection);
            $cid  = $_collection['_id'];
            $userId = $this->module('cockpit')->getUser('_id');

            foreach ($entries as &$entry) {
                $entry = (array)$entry;
                $entry['_by'] = $userId;
                $entry['_mby'] = $userId;
                if (isset($entry['_id']) && !$app->storage->count("collections/{$cid}", ['_id' => $entry['_id']])) {
                    $app->trigger('collections.save.before', [$collection, &$entry, false]);
                    $app->trigger("collections.save.before.{$collection}", [$collection, &$entry, false]);
    
                    $app->storage->insert("collections/{$cid}", $entry);
    
                    $app->trigger('collections.save.after', [$collection, &$entry, false]);
                    $app->trigger("collections.save.after.{$collection}", [$collection, &$entry, false]);
                } else {
                    $this->module('collections')->save($collection, $entry);
                }
            }

            return json_encode([
                'status' => 200,
                'message' => 'Successfully imported!'
            ]);
        };
    });
}
