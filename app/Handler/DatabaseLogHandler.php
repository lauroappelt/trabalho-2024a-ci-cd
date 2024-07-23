<?php

declare(strict_types=1);

namespace App\Handler;

use Hyperf\DbConnection\Db;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class DatabaseLogHandler extends AbstractProcessingHandler
{
    private bool $initialized = false;

    private Db $db;

    public function __construct(Db $db, int|Level|string $level = Level::Debug, bool $bubble = true)
    {
        $this->db = $db;
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        if (! $this->initialized) {
            $this->initialize();
        }

        $this->db->table('log')->insert([
            'channel' => $record->channel,
            'level' => $record->level,
            'message' => $record->formatted,
            'time' => $record->datetime->format('U'),
        ]);
    }

    private function initialize()
    {
        $this->db->statement(
            'CREATE TABLE IF NOT EXISTS log '
            . '(channel VARCHAR(255), level INTEGER, message LONGTEXT, time INTEGER UNSIGNED)'
        );

        $this->initialized = true;
    }
}
