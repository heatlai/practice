<?php

// require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

class Datastore
{
    private static $_datastore;
    private static $_datastoreKey;
    private static $_projectId;
    private static $_namespaceId;

    public static function setDatastore(string $datastoreKey, string $projectId, string  $namespaceId = null)
    {
        self::$_projectId = $projectId;
        self::$_datastoreKey = $datastoreKey;
        self::$_namespaceId = $namespaceId;
    }

    private function _init() : self
    {
        if(static::$_datastore !== null)
        {
            return $this;
        }

        # Instantiates a client
        static::$_datastore = new DatastoreClient([
            'projectId' => static::$_projectId ?? 'GCP_PROJECT_NAME_OR_ID',
            'namespaceId' => static::$_namespaceId ?? 'heat.hypenode.tw',
            'keyFilePath' => __DIR__ . '/Config/Google/' . (static::$_datastoreKey ?? 'project_key.json'),
        ]);

        return $this;
    }

    public function getConnect() : DatastoreClient
    {
        return static::$_datastore;
    }

    public static function getInstance() : self
    {
        static $datastore = null;

        if($datastore === null)
        {
            $datastore = new self();
        }

        $datastore->_init();

        return $datastore;
    }
}