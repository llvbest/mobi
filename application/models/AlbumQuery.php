<?php declare(strict_types=1);

class AlbumQuery extends DbQuery
{
    /** @var string */
    protected $tableName = 'news';
    
    //protected $select;
    /** @var AlbumsFactory */
    private $factory;

    /**
     * AlbumQuery constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @return self
     */
    public function byId(int $id): self
    {
        return $this->addWhereEqual('id', $id);
    }
}
