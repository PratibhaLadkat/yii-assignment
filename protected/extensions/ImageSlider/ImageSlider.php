<?php
class ImageSlider extends CWidget
{

    public $imageBasePath;

    public $images;

    /**
     *
    $this->setAssests();
    return
     */
    public function init()
    {
        $this->setAssests();
        return parent::init();
    }

    /**
     * @throws CException
     */
    public function run()
    {

        if (empty($this->images)) {
            echo "No images present";
            return ;
        }
      //  echo $this->imageBasePath;print_r($this->images);exit;
        $this->render('imageslider', array('imageBasePath' => $this->imageBasePath, 'images' => $this->images));
    }

    /**
     *
     */
    public function setAssests()
    {
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
        Yii::app()->getClientScript()->registerScriptFile($assets . '/js/slider.js', CClientScript::POS_HEAD);
        Yii::app()->getClientScript()->registerCssFile($assets. '/css/slider.css');
    }
}