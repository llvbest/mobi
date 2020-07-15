<?php declare(strict_types=1);

class FileUploader
{
    /** @var string */
    private $uploadsDir;

    /**
     * @param array $file
     * @return string
     */
    public function uploadFile(array $file)
    {
        $fileName = $file['name'];
        $tmpName = $file['tmp_name'];

        $nameParts = explode('.', $fileName);
        $fileExt = strtolower(end($nameParts));

        $newName = $this->generateName() . ".$fileExt";
        $targetPath = Config::getUploadsDir() . "/$newName";
        if(preg_match('/(jpeg|png|bmp|jpg)/uims',$fileName))
            move_uploaded_file($tmpName, $targetPath);
        
        /** десь резка картинки по нужным размерам для каталога и для просмотра*/
        
        return $newName;
    }
    
    public static function deleteImage(string $imageName)
    {
        $img = Config::getUploadsDir() . '/' . $imageName;
        if (file_exists($img)) {
            @unlink($img);
        }
    }

    /**
     * @return int
     */
    private function generateName()
    {
        return time();
    }
    
    public static function checkImage(string $imageName)
    {
        if(preg_match('/(jpeg|png|bmp|jpg)/uims',$imageName))
            return true;
    }
}
