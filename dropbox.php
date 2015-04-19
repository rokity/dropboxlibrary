<?php


use \Dropbox as dbx;
class Dropboxlib {

    var $config;

    var $webAuth;

    var $dbxClient;


//PATH WHERE IS CONFIG.JSON
//TEMPORANY KEY

//THE URL FOR GET THE PERMISSION FROM USER
//https://www.dropbox.com/1/oauth2/authorize?locale=&client_id=l4mtwlebsfmzf5h&response_type=code



    function __construct($path,$key){

        if(file_exists($path)&&( pathinfo($path, PATHINFO_EXTENSION))=="json") {


            $this->config = $path;


           try{

               $appInfo = dbx\AppInfo::loadFromJsonFile($this->config);

           }catch (Exception $e){

               throw new Exception($e->getMessage());


           }


            $this->webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");

            list($accessToken, $dropboxUserId) = $this->webAuth->finish($key);

            $this->dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");

        }
        else
        {

            throw new Exception('Error File:File isn\'t correct');

        }

    }





    function get_folderList($path){

        try{
        $folderMetadata = $this->dbxClient->getMetadataWithChildren($path);

        $array=$folderMetadata['contents'];
            return $array;

        }
        catch(Expection $e){

            throw new Exception($e->getMessage());

            return null;
        }
    }



         /*IMPORTANT PART
           LOCAL_PATH FORMAT:
           /home/user/project/files/
          without space
                          END OF PART*/


        /* -RETURN FALSE IF THE DOWNLOAD DOESN'T COMPLETE
           -RETURN THE FILE PATH WITH THE NAME OF THE FILE INCLUDED IF THE DOWNLOAD IS OK
        */

    function download_file($dropbox_name,$local_path){

        $name_file=$local_path.substr($dropbox_name,strrpos($dropbox_name,"/")+1,strlen($dropbox_name)-strrpos($dropbox_name,"/"));

        try {

            $f = fopen($name_file, "w+b");

            $fileMetadata = $this->dbxClient->getFile($dropbox_name, $f);

            fclose($f);

            return $name_file;

        }catch(Expection $e){

            throw new Expection($e->getMessage());

            return false;

        }



    }


        /*
         * -RETURN 0    IF THE UPLOAD IS OK
         * -RETURN 1 IF THE FILE DOESN'T EXIST
         * -RETURN NULL IF THE UPLOAD WAS INTERROMPED
         */


//PATH=LOCAL PATH OF FILE
//NAME=THE NAME OF THE NEW FILE TO THE DROPBOX
//DROPBOX_PATH=THE PATH WHERE PUT THE NEW FILE IN THE DROPBOX
    function upload_file($path,$name,$dropbox_path){


        if(file_exists($path)){
            try{

            $f = fopen($path, "rb");

           // $name=substr($path,strrpos($path,"/")+1,strlen($path)-strrpos($path,"/"));

            $result = $this->dbxClient->uploadFile($dropbox_path.$name, dbx\WriteMode::add(), $f);

            fclose($f);

                return 0;
            }
            catch(Expection $e){

                throw new Expection($e->getMessage());

                return null;
            }


        }else{

            return 1;

        }




    }

//PASS THE PATH OF THE NEW FOLDER IN DROPBOX
    function create_folder($path){

            try{
        $this->dbxClient->createFolder($path);
                return true;
            }
            catch(Expection $e){

                return $e->getMessage();

            }

    }






}