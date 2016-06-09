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
    // 新しいインスタンスを作成
    public static function getInstance()
    {
        return new self();
    }

    /**
     * データ作成
     * @param \Localinfo
     * @return bool
     */
    public function createData($localinfo, $path)
    {
        $this->set('localinfo_id', $localinfo->id);
        $this->set('image', $path);
        $this->set('status', 'valid');
    }

    /*
     * ポストされたファイル情報からデータを作成
     */
    public static function createDataFromPostFile($localinfo, $file, $uploader, $transaction, $accountId)
    {
        $path = self::getFilePath($localinfo);
        $filename = self::getFileName($accountId, $file);
        $uploader->scpFile($file->getTempName(), $path, $filename);

        $image = self::getInstance();
        $image->setTransaction($transaction);
        $image->createData($localinfo, $path.$filename);
        if ($image->save() === false) {
            $transaction->rollback("Cannot save");
            return null;
        }
        return $image;
    }


    /**
     * サムネイル画像のパス
     */
    public function getThumbnailUrl()
    {
        return APP_IMAGE_DOMAIN.'/pf/localinfo/'.$this->image;
    }

    /**
     * メイン画像のパス
     */
    public function getImageUrl()
    {
        return APP_IMAGE_DOMAIN.'/pf/localinfo/'.$this->image;
    }

    /*
     * 保存するファイルパス
     */
    public static function getFilePath($localinfo)
    {
        // 画像を保存するパス
        // 県ID/市区町村ID/年/月/日/
        return sprintf('%d/%d/%s',
                       (int)$localinfo->prefecture_id,
                       (int)$localinfo->area_id,
                       date('Y/m/d')
                       );
    }


    // 保存する画像名
    // <投稿ユーザID>_<画像キー>_<unixtime>_filename.xxx
    public static function getFileName($accountId, $file)
    {
        return sprintf('/%d_%s_%d_%s',
                       $accountId,
                       $file->getKey(),
                       time(),
                       $file->getName()
                       );
    }
}
