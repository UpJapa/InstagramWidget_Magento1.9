<?php

class MageShop_Instagramwidget_GraphController extends Mage_Core_Controller_Front_Action
{

    private $imagensdatabase;
    private $imagensInstagram;
    private $inserts;
    private $token;
    private $response = [];

    /**
     * Método responsável por gerar as imagens
     * pode ser executado por get curl -i -X GET "base_url/feed/graph/media"
     * @return void
     */
    public function mediaAction()
    {
        $this->token = Mage::helper('instagramwidget')->getToken();
        # http://php.net/manual/en/class.datetimeinterface.php#datetime.constants.types

        $this->imagensdatabase = Mage::getModel('instagramwidget/instagramwidget')->getCollection()->getData();
       
        $media = $this->getIdMidia();

        if(isset($media['erro'])){
            $this->response = [ 'type' => 'error', "message" => $media['erro']['message']];
        }
        
        if(isset($media['media'])){
            
            foreach ($media['media']['data'] as $key => $value) {
                if($this->compare($value) == false){
                    unset($media['media']['data'][$key]);
                }
            }

            if(count($media['media']['data']) > 0){

                $imagens_json = $this->getImgInstagramApi($media['media']['data']);
           
                foreach ($imagens_json as $value) {
                        $this->imagensInstagram [] = json_decode($value, true);
                }
    
                foreach($this->imagensInstagram as $imageapi){
    
                    if(isset($imageapi['erro'])){
                        $this->response = [ 'type' => 'error', "message" => $imageapi['erro']['message']];
                    }else{
                        $this->inserts [] = [
                            "id" => $imageapi['id'],
                            "file" => isset($imageapi['thumbnail_url']) && !empty($imageapi['thumbnail_url'])  ? $imageapi['thumbnail_url'] : $imageapi['media_url'] ,
                            "permalink" => $imageapi['permalink'],
                            "alt" => $imageapi['caption']
                        ];
                    }
                }
            }
        }

      

        if($this->inserts){ 
            $this->saveImage();
        }else if(empty($this->response)){
            $this->response = ["type" => 'success' , "message" => "Dados Atualizados"];
        }
        // excuir imagens que não estão mais no instagram
        $this->massDelete();
        
       
        echo json_encode($this->response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
    }

    /**
     * Método responsável por atualizar o token antigo por um novo 
     * pode ser executado por get curl -i -X GET "base_url/feed/graph/newtoken"
     * @return bool
     */
    public function newtokenAction()
    {
        $this->token = Mage::helper('instagramwidget')->getToken();
        
        if(empty($this->token)){
            return false;
        }

        $url = 'https://graph.instagram.com/v12.0/refresh_access_token?grant_type=ig_refresh_token&access_token=' .$this->token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        if(isset($response['error']) OR empty($response['access_token'])){
            return false;
        }

        // atualização do token 
        $query =  "UPDATE core_config_data SET value ='{$response['access_token']}' WHERE path = '".Mage::helper('instagramwidget')::TOKEN."';";
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $writeConnection->query($query);
        $writeConnection->closeConnection();
        return true;
    }

    private function saveImage()
    {

        $folder = Mage::getBaseDir('media') . DIRECTORY_SEPARATOR . "instagramwidget" . DIRECTORY_SEPARATOR;

        if(!is_dir($folder)){
            mkdir($folder,0777);
        }

        foreach($this->inserts as &$data){
            $getNameImage = explode("?", $data['file']);
            $getNameImage = explode("/", $getNameImage[0]);
            $nameImage = end($getNameImage);
            $this->downloadimage($data['file'], $folder.$nameImage);
            $data['file'] = $nameImage;
        }

        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $connection->insertMultiple('instagramwidget', $this->inserts);

        $this->response = ["type" => 'success', "message" => "Dados Atualizados"];
    }

    /**
     * Método responsável pro baixar as imagens
     *
     * @param string $inPath URL da imagem
     * @param string $outPath Caminho e nome que será salvo 
     * @return void
     */
    private function downloadimage($inPath,$outPath)
    {
        
        $in=    fopen($inPath, "rb");
        $out=   fopen($outPath, "wb");
        while ($chunk = fread($in,8192))
        {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    /**
     * Exclui as imagens em massa
     *
     * @return void
     */
    private function massDelete(){

        try{

            $imageModel = Mage::getModel('instagramwidget/instagramwidget');
            $path = Mage::getBaseDir('media') . DIRECTORY_SEPARATOR . "instagramwidget" . DIRECTORY_SEPARATOR;
            foreach($this->imagensdatabase as $value){

                $objModel = $imageModel->load($value['id']);

                $file = $path . $value['file'];

                if(file_exists($file)){
                    unlink($file);
                }

                $objModel->delete();
            }
        }catch(Exception $e){
            $this->response = ['type' => 'error' , "message" => $e->getMessage()];
        }
    }

    /**
     * Compara se os valores são iguais
     * false se são iguais;
     * true se é para insert;
     * @return bool
     */
    private function compare($imageApi){
        
        if($this->imagensdatabase){
            foreach ($this->imagensdatabase as $key => $value){
                if($value['id'] == $imageApi['id']){
                    unset($this->imagensdatabase[$key]);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Método que pega os ids das imagens e retorna para o php
     *
     * @return array
     */
    private function getIdMidia()
    {
        $url = 'https://graph.instagram.com/v12.0/'.Mage::helper('instagramwidget')->getIdUser().'?fields=media&access_token='.$this->token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Pega as imagens na api em massa
     *
     * @param array $ids
     * @return array
     */
    private function getImgInstagramApi($data)
    {

        // array of curl handles
        $multiCurl = array();
        // data to be returned
        $result = array();
        // multi handle
        $mh = curl_multi_init();

        foreach ($data as $i => $id) {
        // URL from which data will be fetched
            $fetchURL = 'https://graph.instagram.com/v12.0/'.$id['id'].'?fields=media_type,media_url,username,thumbnail_url,permalink,caption&access_token='.$this->token;
            $multiCurl[$i] = curl_init();
            curl_setopt($multiCurl[$i], CURLOPT_URL,$fetchURL);
            curl_setopt($multiCurl[$i], CURLOPT_HEADER,0);
            curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER,1);
            curl_multi_add_handle($mh, $multiCurl[$i]);
        }

        $index=null;

        do {
            curl_multi_exec($mh,$index);
        } while($index > 0);

        // get content and remove handles
        foreach($multiCurl as $k => $ch) {
            $result[$k] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
        }
        
        // close
        curl_multi_close($mh);

        return $result;

    }
}
