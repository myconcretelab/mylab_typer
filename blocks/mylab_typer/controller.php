<?php
namespace Concrete\Package\MylabTyper\Block\MylabTyper;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btTable = 'btMylabTyper';
    protected $btInterfaceWidth = "600";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";
    protected $btCacheBlockRecord = false;
    protected $btCacheBlockOutput = false;
    protected $btCacheBlockOutputOnPost = false;
    protected $btCacheBlockOutputForRegisteredUsers = false;

    public function getBlockTypeDescription()
    {
        return t("Add a nice typer");
    }

    public function getBlockTypeName()
    {
        return t("Typer");
    }

    public function registerViewAssets()
    {
        $this->requireAsset('javascript', 'jquery');

    }
    public function composer() {
        $this->setAssetEdit();
              
    }    
    public function view()
    {

        // this doesn't work for now, it need to adapt the javascript to display html element
        $comaSeparatedSentence = preg_replace('#\*{2}(.*?)\*{2}#', '<strong>$1</strong>', $this->comaSeparatedSentence);
        $firstSentence = explode(',', $comaSeparatedSentence);
        $comaSeparatedSentence = json_encode($comaSeparatedSentence = explode(',', $comaSeparatedSentence));
        $firstSentence = count($firstSentence) ? $firstSentence[0] : "";

        $this->set('comaSeparatedSentence', $comaSeparatedSentence);
        $this->set('firstSentence', $firstSentence );

        $options =  json_decode($this->options);       
        $this->set('options', $options );

    }



    public function save($args)
    {
        $options = $args;
        unset($options['setenceStart']); unset($options['comaSeparatedSentence']); unset($options['setenceEnd']); 
        $args['options'] = json_encode($options);

        // $args['fIDs'] = implode(',', $args['fID']);
        // $args['galleryColumns'] =  $args['galleryColumns'] ? $args['galleryColumns'] : 4;
        parent::save($args);
    }

}
