<?php 
$rootPath = realpath(dirname(__FILE__)."/../../../../");

if (@include_once $rootPath."/lib/confs/sysConf.php") {
    $conf = new sysConf();
    $version = $conf->getVersion();
}
$prodName = 'MasakhaneHRM';
$copyrightYear = date('Y');

?>
<?php echo $prodName . ' ' . $version;?><br/>
