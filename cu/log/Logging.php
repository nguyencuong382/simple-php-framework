<?php
    namespace Cu\Log;

    class Logging {
      const FILE_NAME = __DIR__ . '/log.txt';

      public static function log($message) {
        file_put_contents(self::FILE_NAME, $message.\PHP_EOL, \FILE_APPEND | \LOCK_EX);
      }
    }
?>