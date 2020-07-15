<?php declare(strict_types=1);

class DbConnection
{
    /** @var DbConnection */
    private static $instance;
    /** @var \PDO */
    private $pdo;

    /**
     * DbConnection constructor.
     * @param string $dsn
     * @param string $user
     * @param string $pwd
     */
    private function __construct(string $dsn, string $user, string $pwd)
    {
        $this->pdo = new \PDO($dsn, $user, $pwd);
    }

    /**
     * @return DbConnection
     */
    public static function instance()
    {
        if (null === self::$instance) {
            $dsn = sprintf('%s:host=%s;dbname=%s;charset=utf8',
                Config::DB_DRIVER,
                Config::DB_HOST,
                Config::DB_NAME
            );
            self::$instance = new self($dsn, Config::DB_USER, Config::DB_PASS);
        }
        return self::$instance;
    }

    /**
     * @param $value
     * @return string
     */
    public function quote($value)
    {
        return $this->pdo->quote((string) $value);
    }

    /**
     * @param $name
     * @return string
     */
    public function quoteCol(string $name): string
    {
        return "`$name`";
    }

    /**
     * @param array $names
     * @return array
     */
    public function quoteColMultiple(array $names): array
    {
        return array_map(function($name) {
            return $this->quoteCol($name);
        }, $names);
    }

    /**
     * @param array $values
     * @return array
     */
    public function quoteMultiple(array $values)
    {
        return array_map(function($val) {
            return $this->quote((string) $val);
        }, $values);
    }

    /**
     * @param string $sql
     * @return array
     */
    public function query(string $sql)
    {
        if ($rows = $this->pdo->query($sql, \PDO::FETCH_ASSOC)) {
            foreach ($rows as $row) {
                $result[] = $row;
            }
        }

        return $result ?? [];
    }

    /**
     * @param string $sql
     * @return int
     */
    public function execute(string $sql)
    {
        return $this->pdo->exec($sql);
    }
}
