<?php

namespace Config;
use CodeIgniter\Config\BaseConfig;

class FtpConfig extends BaseConfig {
    public $host = '127.0.0.1';
    public $username = 'digital';
    public $password = 'P@ssw0rd';
    public $folderIn = '/file_in';
    public $folderOut = '/file_out';
    public $folderResult = '/file_result';
    public $localFolderIn = '//Users/arifdermawan/Documents/ftp/local_folder/file_in';
    public $localFolderOut = '//Users/arifdermawan/Documents/ftp/local_folder/file_out';
    public $localFolderOutSuccess = '//Users/arifdermawan/Documents/ftp/local_folder/file_out/success';
    public $port = 21;
    public $timeOut = 90;
}