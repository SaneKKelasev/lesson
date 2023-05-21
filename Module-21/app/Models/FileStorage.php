<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TelegraphText;

class FileStorage extends Model
{
    use HasFactory;

    public function createFileStorage( TelegraphText $store)
    {
        $fileName = $store->slug . '_' . date('d.m.Y');

        while (true) {
            if (!file_exists($fileName)) {
                $store->slug = $fileName;
                file_put_contents($fileName, serialize($store));

                return $store->slug;
            }

            $arrFileName = explode('_', $fileName);

            if (count($arrFileName) === 3) {
                $fileName = $arrFileName[0] . '_' . $arrFileName[1] . '_' . ((int)$arrFileName[2] + 1);
            } else {
                $fileName = $arrFileName[0] . '_' . $arrFileName[1] . '_' . 1;
            }
        }
    }

    public function readFileStorage( string $identifierStore )
    {
        if (file_exists($identifierStore)) {
            return unserialize(file_get_contents($identifierStore));
        }
    }

    public function updateFileStorage( string $identifierStore, TelegraphText $store )
    {
        if (file_exists($identifierStore)) {
            unlink($identifierStore);
            file_put_contents($identifierStore, serialize($store));
        }
    }

    public function deleteFileStorage( string $identifierStore )
    {
        if (file_exists($identifierStore)) {
            unlink($identifierStore);
        }
    }

    public function list()
    {
        $listFile = scandir('./');
        $listObject = [];

        foreach ($listFile as $file) {
            $listObject[] = unserialize($file);
        }

        return $listObject;
    }


    // methods interface EventListenerInterface.php
    public function attachEvent(string $methodName, callable $callback)
    {
        // TODO: Implement attachEvent() method.
    }

    public function detouchEvent(string $methodName)
    {
        // TODO: Implement detouchEvent() method.
    }



    // methods interface LoggerInterface
    public function logMessage(string $textError)
    {
        // TODO: Implement logMessage() method.
    }

    public function lastMessages(int $countMessage) : array
    {
        // TODO: Implement lastMessages() method.
        return [];
    }
}
