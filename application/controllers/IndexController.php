<?php
class IndexController extends Controller{
    /**
     * global array params
     * @var Request Object
     */
    public $request;
    
    public $memcache;
    
    public $category = ['category 0','category 1','category 2','category 3','category 4'];

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        
        $this->memcache = new Memcached();
        $this->memcache->addServer('localhost', 11211);
    }
    
    function index(){
        $page = $this->request->getParam('page') ?? 1;
        $filtersParams = $this->request->getFiltersParams();
        $filtersParamsKey = implode(',',$filtersParams).'_'.$page;
        
        $sizeItems = $this->memcache->get('sizeItems_'.$filtersParamsKey);
        if(empty($sizeItems)){
            /** count records */
            $model = new AlbumQuery();
            $model->select = 'count(*) as total';
            /** applly filters */
            foreach ($filtersParams as $filters_key => $filters_value) {
                $model->addWhereEqual($filters_key, $filters_value);
            }
            $count = $model->first();
            $sizeItems = $count['total'];
            
            $this->memcache->set('sizeItems_'.$filtersParamsKey,$sizeItems);
        }
        
        $sortBy = $this->request->getSortParam();
        $sortDirection = $this->request->getSortDirection();
        
        $results = $this->memcache->get('results_'.$filtersParamsKey.'_'.$sortBy.'_'.$sortDirection);
        if(empty($results)){
            /** items query builder */
            $model = new AlbumQuery();
            $model->page = $page;
            
            /** applly filters */
            foreach ($filtersParams as $filters_key => $filters_value) {
                $model->addWhereEqual($filters_key, $filters_value);
            }
            
            /** applly sort */
            if($sortBy) {
                $model->addOrderBy($sortBy, $sortDirection);
            }
            
            $results = $model->all();
            $this->memcache->set('results_'.$filtersParamsKey.'_'.$sortBy.'_'.$sortDirection,$results);
        }
        
        /** update form album */
        $itemId = $this->request->getParam('itemId');
        if($itemId) {
            $modelFrom = new AlbumQuery();
            $modelResults = $modelFrom->byId($itemId)->first();
        }

		include ROOT.'application/views/index/index.php';
	}
    /**
        action insert or update
    */
    function insert(){
        $this->memcache->flush();
        $id = $this->request->getPostParam('id');
        
        $file = $this->request->getFiles();

        if(!empty($file['image'])){
            $fileUploader = new FileUploader();
            $imageName = $fileUploader->uploadFile($file['image']) ?? null;
        }
            
        if(empty($id)){
            $model = new AlbumQuery();
            $keys = array_keys($this->request->postParams());
            $values = array_values($this->request->postParams());
            $id = empty($values[0])? $values[0] = '0' : '';
            
            if(FileUploader::checkImage($imageName)){
                $keys[] = 'imageName';
                $values[] = ($imageName) ?? null;
            }

            $status = $model->insert($keys, $values);
        } else {
            $model = new AlbumQuery();
            $result = $model->byId($id)->first();
            
            if(!empty($result['imageName']))
                FileUploader::deleteImage($result['imageName']);
                
            $params = $this->request->postParams();
            $params['imageName'] = $imageName;
            
            $model = new AlbumQuery();
            $model->update($id, $params);
        }
        header("Location: http://" . $_SERVER["HTTP_HOST"]);
        exit();
	}

    /**
        action delete
    */
    function delete(){
        $this->memcache->flush();
        $id = $_GET['id'];
        if(!empty($id)) {
            $model = new AlbumQuery();
            $result = $model->byId($id)->first();
            
            /** delete model */
            $status = $model->delete($id);
            
            if(!empty($result['imageName']))
                FileUploader::deleteImage($result['imageName']);
        }
        echo json_encode([
            'status' => 1,
            'msg' => 'Delete success',
        ]);
	}
    
    /**
     * memcache->flush
     */
    function flush(){
        $this->memcache->flush();
    }
}