<?php declare(strict_types=1);

class Request
{
    /**
     * Dirty GET params array
     * @var array
     */
    private $get;

    /**
     * Dirty POST params array
     * @var array
     */
    private $post;

    /**
     * @var array
     */
    private $files;

    /**
     * @var mixed
     */
    private $uri;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->uri = ($_SERVER['REQUEST_URI'])??null;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
    }

    /**
     * AJAX request performed
     */
    public function isAjax() : bool
    {
        $ajaxParam = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        return $ajaxParam && strtolower($ajaxParam === 'xmlhttprequest');
    }

    /**
     * @return string
     */
    public function getControllerName() : string
    {
        $parts = $this->getPathParts();
        return isset($parts[0]) ? strtolower($parts[0]) : '';
    }

    /**
     * @return string
     */
    public function getControllerAction() : string
    {
        $parts = $this->getPathParts();
        return isset($parts[1]) ? strtolower($parts[1]) : '';
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return (string) parse_url($this->uri, PHP_URL_PATH);
    }

    /**
     * @return array
     */
    public function getPathParts() : array
    {
        return explode('/', ltrim($this->getPath(), '/'));
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        // TODO: Sanitize
        return $this->get;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getParam(string $name)
    {
        return isset($this->get[$name]) ? $this->get[$name] :  null;
    }
    
    /**
     * @param string $name
     * @return mixed|null
     */
    public function getPostParam(string $name)
    {
        return isset($this->post[$name]) ? $this->post[$name] :  null;
    }    

    /**
     * @return array
     */
    public function postParams(): array
    {
        // TODO: Sanitize
        return $this->post;
    }
    
    /**
     * @return array
     */
    public function getFiltersParams(): array
    {
        $getFilters = [];
        foreach ($this->get as $filterKey => $filterValue) {
            if(preg_match('/^f_/uims',$filterKey))
                $getFilters[str_replace('f_','',$filterKey)] = $filterValue;
        }
        return $getFilters;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }
    
    /**
     * @param string $name
     * @return mixed|null
     */
    public function getSortParam(string $name = 'sort')
    {
        return isset($this->get[$name]) ? str_replace('-','',$this->get[$name]) :  null;
    }
    
    /**
     * @param string $name
     * @return mixed|null
     */
    public function getSortDirection(string $name = 'sort')
    {
        $sort = isset($this->get[$name]) ? $this->get[$name] :  null;
        if($sort)
            return preg_match('/^-/uim', $sort)? SORT_DESC : SORT_ASC;
                else
                    return false;
    }
}
