<?php
require_once("conf/config.inc.php");
require_once("conf/settings.inc.php");
if (!isset($language)) {
  $language = 'en';
}
include('locale/' . $language . '.php');

// installation nouvelle version automatique 

$github = 'https://github.com/Jahislove/Hargassner/archive/master.zip';

/******* fonction de copie recursive**************************/
function copyr($source,$dest) {
    if (is_file($source)) {
        return copy($source,$dest);
    }
    if (!is_dir($dest)) {
        mkdir("$dest");
    }
    $dir = opendir($source);
    while (false !== ($entry = readdir($dir))){
        if ($entry == '.' || $entry == '..' || $entry == 'backup'|| $entry == 'update'|| $entry == '.git'|| $entry == 'config.inc.php' || $entry == 'settings.inc.php' || $entry == 'php.ini') {
            continue;
        }
        copyr("$source/$entry", "$dest/$entry");
    }
    closedir($dir);
    return true;
}
/******* fonction de delete recursive**************************/
function unlinkRecursive($source,$deleteRoot){
    if(!$dir = opendir($source)){
        return;
    }
    while (false !== ($entry = readdir($dir))){
        if($entry == '.' || $entry == '..'){
            continue;
        }

        if (!unlink($source . '/' . $entry)){
            unlinkRecursive($source.'/'.$entry,true);
        }
    }
    closedir($dir);
    if ($deleteRoot){
        rmdir($source);
    }
    return true;
} 

/******* Telechargement nouvelle version ***********************/
function download($source) {
	echo text_download .' ';
    if (copy ($source,'update/master.zip')) {
        echo text_OK .'<br>';
        return true;
    } else {
        echo text_ERROR .'<br>';
        echo text_cancel .'<br>';
        echo text_help .'<br>';
        return false;
    }
}
/******* unzip nouvelle version *******************************/
function unzip() {
    $zip = new ZipArchive;
    echo text_extract .'<br>';
    if ($zip -> open('update/master.zip')) {
        $zip -> extractTo('update/');
        $zip -> close;
        echo text_OK .'<br>';
        return true;
    } else {
        echo text_ERROR .'<br>';
        echo text_cancel .'<br>';
        return false;
    }
}
/******* purge ancien backup***************************************/
function purge() {
    $source = "update/backup";
	echo text_delete .'<br>';
    if (unlinkRecursive ($source,false)) {
        echo text_OK .'<br>';
        return true;
    } else {
        echo text_ERROR .'<br>';
        echo text_cancel .'<br>';
        return false;
    }
}
/******* backup du site***************************************/
function backup() {
    $source = ".";
	echo text_backup .'<br>';
    $dest= "update/backup/$source";
    if (copyr ($source,$dest)) {
        copy("conf/config.inc.php","update/backup/conf/config.inc.php");
        echo text_OK .'<br>';
        return true;
    } else {
        echo text_ERROR .'<br>';
        echo text_cancel .'<br>';
        return false;
    }
}
/******* installation nouvelle version************************/
function installation() {
    $source = "update/Hargassner-master";
    $dest= "."; 
	echo text_update .'<br>';

    if (copyr ($source,$dest)) {
        echo text_OK .'<br>';
    } else {
        echo text_ERROR .'<br>';
        echo text_cancel .'<br>';
    }
}

/************enchainement des actions **************************/
if (!is_dir("update")) {
    mkdir("update");
}
if (!is_dir("update/backup")) {
    mkdir("update/backup");
}

unlinkRecursive ("update/Hargassner-master",true);
unlink("update/master.zip");

if (download($github)){
    if (unzip()){ 
        if (purge()){
            if (backup()){
                installation();
				//ajout nouveau parametre dans config.php
				// si un fichier de nouveau parametre existe
				if (is_file('conf/new_param.txt')) {
					
					$new_param = file('conf/new_param.txt');// ecrit parametres dans tableau
					$new_param = array_reverse($new_param); // inverse le tableau
					$k = floor(count($new_param)/2);// divise par 2 pour avoir le nombre de couple

					$old_lignes = file('conf/config.inc.php'); //ecrit fichier dans tableau
					for ($i = 0; $i < $k; $i++){
						array_splice($old_lignes,$new_param[$i*2],0,$new_param[$i*2+1]);// insert lignes
					}
					$new_content = join('',$old_lignes);
					$fp = fopen('conf/config.inc.php','w');
					$write = fwrite($fp, $new_content);
					fclose($fp);

					// avertir
					
					unlink('conf/new_param.txt');
				}
            }
        }
    }
}
echo '<a href="index.php">Reload</a> ';

?>  