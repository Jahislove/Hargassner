<?php
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
        if ($entry == '.' || $entry == '..' || $entry == 'backup'|| $entry == 'update'|| $entry == '.git'|| $entry == 'config.inc.php') {
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
    if (copy ($source,'update/master.zip')) {
        echo 'Telechargement nouvelle version OK<br>';
        return true;
    } else {
        echo "Erreur de telechargement : annulation de l'installation";
        return false;
    }
}
/******* unzip nouvelle version *******************************/
function unzip() {
    $zip = new ZipArchive;
    if ($zip -> open('update/master.zip')) {
        $zip -> extractTo('update/');
        $zip -> close;
        echo 'Extraction nouvelle version OK<br>';
        return true;
    } else {
        echo "Erreur d'extraction : annulation de l'installation";
        return false;
    }
}
/******* purge ancien backup***************************************/
function purge() {
    $source = "update/backup";
    if (unlinkRecursive ($source,false)) {
        echo "Purge ancienne sauvegarde OK<br>";
        return true;
    } else {
        echo "Erreur purge ancienne sauvegarde : annulation de l'installation";
        return false;
    }
}
/******* backup du site***************************************/
function backup() {
    $source = ".";
    $dest= "update/backup/$source";
    if (copyr ($source,$dest)) {
        copy("conf/config.inc.php","update/backup/conf/config.inc.php");
        echo "Sauvegarde OK<br>";
        return true;
    } else {
        echo "Impossible de faire une sauvegarde : annulation de l'installation";
        return false;
    }
}
/******* installation nouvelle version************************/
function installation() {
    $source = "update/Hargassner-master";
    $dest= "."; 

    if (copyr ($source,$dest)) {
        echo "Installation OK<br>";
    } else {
        echo "Erreur d'installation : annulation de l'installation";
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
            }
        }
    }
}
echo '<a href="index.php">Recharger le site</a> ';

?>  