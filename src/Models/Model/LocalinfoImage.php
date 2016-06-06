<?php
/**
 * Lapi\Models\Model
 */
namespace Lapi\Models\Model;

/**
 * LocalinfoImage
 */
class LocalinfoImage extends \Lapi\Models\Model\UserAbstract
{
    /**
     * サムネイル画像のパス
     */
    public function getThumbnailUrl()
    {
        $config = require APP_DIR.'/v1/config/config.d/config.php';
        $imageDomain = $config[APPLICATION_ENV]['image_domain'];
        return $imageDomain.'localinfo/'.$this->image;
    }

    /**
     * メイン画像のパス
     */
    public function getImageUrl()
    {
        $config = require APP_DIR.'/v1/config/config.d/config.php';
        $imageDomain = $config[APPLICATION_ENV]['image_domain'];
        return $imageDomain.'localinfo/'.$this->image;
    }
}
