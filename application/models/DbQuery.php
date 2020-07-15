<?php declare(strict_types=1);

abstract class DbQuery
{
    public $select;
    protected $from;
    protected $tableName;
    protected $where = [];
    protected $orderBy = [];
    public $pageSize = Config::PAGE_COUNT;
    public $page = 1;

    /**
     * @var DbConnection
     */
    private $db;

    public function __construct()
    {
        $this->db = DbConnection::instance();
    }

    /**
     * @return array
     */
    public function all()
    {
        /*return array_map(function($row) {
            return $this->createEntity($row);
        }, $this->db->query($this->getSql()));*/
        return $this->db->query($this->getSql());
    }

    /**
     * @return AbstractEntity|null
     */
    public function first()
    {
        $list = $this->all();
        return \count($list) ? array_values($list)[0] : null;
    }

    /**
     * @param $row
     * @return AbstractEntity
     */
    //abstract protected function createEntity($row);

    /**
     * @return string
     */
    protected function getSql()
    {
        $sql  = $this->getSelectSql() ;
        $sql .= $this->getFromSql();
        $sql .= $this->getWhereSql();
        $sql .= $this->getOrderBySql();
        if(empty($this->select))
            $sql .= ' LIMIT '.$this->pageSize.' OFFSET '.( ($this->page-1)*$this->pageSize);
        return $sql;
    }

    /**
     * @return string
     */
    public function getSelectSql()
    {
        return 'SELECT ' . ($this->select ?? '*');
    }

    /**
     * @param string $orderBy
     * @param int    $direction SORT_DESC | SORT_ASC
     * @return DbQuery
     */
    public function addOrderBy(string $orderBy, int $direction)
    {
        $desc = $direction === SORT_DESC ? ' DESC' : '';
        $this->orderBy[] = "`$orderBy`$desc";
        return $this;
    }

    /**
     * @param string $colName
     * @param        $value
     * @return $this
     */
    public function addWhereEqual(string $colName, $value)
    {
        if (!is_int($value)) {
            $value = $this->db->quote($value);
        }
        $this->where[] = "`$colName` = $value";
        return $this;
    }

    /**
     * @param string $colName
     * @param string $value
     * @return self
     */
    public function addWhereLike(string $colName, string $value): self
    {
        $value = $this->db->quote("%$value%");
        $this->where[] = "`$colName` LIKE $value";
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFromSql(): string
    {
        return " FROM `{$this->tableName}`";
    }

    /**
     * @param array $columns
     * @param array $values
     * @return int
     */
    public function insert(array $columns, array $values)
    {
        if (\count($columns) !== \count($values)) {
            $err = 'Number of columns should be equal to number of values';
            throw new \InvalidArgumentException($err);
        }

        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s);",
            $this->tableName,
            implode(', ', $this->db->quoteColMultiple($columns)),
            implode(', ', $this->db->quoteMultiple($values))
        );

        return $this->db->execute($sql);

    }

    public function update(int $id, array $data)
    {
        $setParams = [];
        foreach ($data as $name => $value) {
            $column = $this->db->quoteCol($name);
            $value = $this->db->quote((string) $value);
            $setParams[] = "$column = $value";
        }

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = %d",
            $this->db->quoteCol($this->tableName),
            implode(', ', $setParams),
            $this->db->quoteCol('id'),
            $id
        );

        return $this->db->execute($sql);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        $sql = sprintf("DELETE FROM %s WHERE %s = %d",
            $this->tableName,
            $this->db->quoteCol('id'),
            $id
        );
        return $this->db->execute($sql);
    }

    /**
     * @return string
     */
    private function getWhereSql()
    {
        if ($this->where) {
            return ' WHERE ' . implode(' AND ', $this->where);
        }
        return '';
    }

    /**
     * @return string
     */
    private function getOrderBySql()
    {
        if ($this->orderBy) {
            return ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        return '';
    }
}
