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
        return APP_IMAGE_DOMAIN.'/localinfo/'.$this->image;
    }

    /**
     * メイン画像のパス
     */
    public function getImageUrl()
    {
        return APP_IMAGE_DOMAIN.'/localinfo/'.$this->image;
    }
}
