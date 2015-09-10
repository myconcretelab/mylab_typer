<?php

namespace Concrete\Package\MylabTyper;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Template as PageTemplate;
use Concrete\Core\Page\Theme\Theme as PageTheme;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Route;

defined('C5_EXECUTE') or die('Access Denied.');


class Controller extends \Concrete\Core\Package\Package {

    protected $pkgHandle = 'mylab_typer';
    protected $appVersionRequired = '5.7.0.4';
    protected $pkgVersion = '0.9.0';
    protected $pkg;
    
    public function getPackageDescription() {
        return t("ImageBasic install two useful block for your client");
    }
    
    public function getPackageName() {
        return t("Typer");
    }   

    public function on_start() { 
        $al = AssetList::getInstance(); 
        $al->register( 'javascript', 'knob', 'blocks/mylab_typer/javascript/build/jquery.knob.js', array('version' => '1.2.11', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        $al->register( 'javascript', 'filemanagersearch', 'blocks/mylab_typer/javascript/file-manager/search.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        $al->register( 'javascript', 'filemanagermenu', 'blocks/mylab_typer/javascript/file-manager/menu.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       


        $al->register( 'javascript', 'fileuploadiframe', 'blocks/mylab_typer/javascript/file-manager/jquery-iframe-transport.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        $al->register( 'javascript', 'filemanagerselector', 'blocks/mylab_typer/javascript/file-manager/selector.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       

        $al->register( 'javascript', 'typer-edit', 'blocks/mylab_typer/javascript/build/block-edit.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'javascript', 'canvas-to-blob', 'blocks/mylab_typer/javascript/build/canvas-to-blob.min.js', array('version' => '1.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'javascript', 'fileupload-image', 'blocks/mylab_typer/javascript/build/jquery.fileupload-image.js', array('version' => '1.7.2', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'javascript', 'fileupload-process', 'blocks/mylab_typer/javascript/build/jquery.fileupload-process.js', array('version' => '1.3.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'javascript', 'iframe-transport', 'blocks/mylab_typer/javascript/build/jquery.iframe-transport.js', array('version' => '1.8.2', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'javascript', 'load-image', 'blocks/mylab_typer/javascript/build/load-image.all.min.js', array('version' => '1.0', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        // $al->register( 'css', 'animate', 'themes/ImageBasic/css/animate.css', array('version' => '1.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => true, 'combine' => true), $this ); 

        $al->register( 'css', 'typer-edit', 'blocks/mylab_typer/stylesheet/block-edit.css', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       

        // View items
        $al->register( 'javascript', 'intense', 'blocks/mylab_typer/javascript/build/intense.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this );       
        $al->register( 'javascript', 'masonry', 'blocks/mylab_typer/javascript/build/masonry.pkgd.min.js', array('version' => '3.1.4', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this ); 
        $al->register( 'javascript', 'mason', 'blocks/mylab_typer/javascript/build/mason.js', array('version' => '1.5', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this ); 
        $al->register( 'javascript', 'imagesloaded', 'blocks/mylab_typer/javascript/build/imagesloaded.pkgd.min.js', array('version' => '3.1.4', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this ); 
        $al->register( 'javascript', 'packery', 'blocks/mylab_typer/javascript/build/packery.pkgd.min.js', array('version' => '3.1.4', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => true, 'combine' => true), $this ); 

        $this->registerRoutes();
    }
    public function registerRoutes()
    {
        Route::register('/mylabtyper/tools/savefield','\Concrete\Package\MylabTyper\Controller\Tools\MylabTyperTools::save');
        Route::register('/mylabtyper/tools/getfilesetimages','\Concrete\Package\MylabTyper\Controller\Tools\MylabTyperTools::getFileSetImage');
        Route::register('/mylabtyper/tools/getfiledetailsjson','\Concrete\Package\MylabTyper\Controller\Tools\MylabTyperTools::getFileDetailsJson');


    }    
    public function install() {
    
    // Get the package object
        $this->pkg = parent::install();

    // Installing                   
         $this->installOrUpgrade();        

    }

    private function installOrUpgrade() {

        $this->getOrInstallBlockType('mylab_typer');

    }    

    function upgrade () {
        $this->pkg = $this;
        $this->installOrUpgrade();
    }


    private function getOrInstallBlockType($btHandle) {
        $bt = BlockType::getByHandle($btHandle);
        if (empty($bt)) {
            BlockType::installBlockTypeFromPackage($btHandle, $this->pkg);
            $bt = BlockType::getByHandle($btHandle);
        }
        return $bt;
    }    
}