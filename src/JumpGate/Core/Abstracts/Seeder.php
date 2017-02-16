<?php

namespace JumpGate\Core\Abstracts;

abstract class Seeder extends \Illuminate\Database\Seeder
{
    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db;

    public function __construct()
    {
        $this->db = app('db');
    }

    /**
     * Truncate the existing table of all records.
     *
     * @param string $table
     */
    protected function truncate($table)
    {
        if ($this->db->connection()->getConfig('driver') === 'mysql') {
            $this->db->statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->db->table($table)->truncate();
            $this->db->statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
