<?php
/**
 * Papi\Utils
 */
namespace Papi\Utils;

use Gcl\Util\GArray;

/**
 * Text
 */
class Text
{
    const REPLACEMENT_NICKNAME = '{%nickname}';
    const REPLACEMENT_TOKEN = '{%token}';

    /**
     * 文字列置換
     * @param  string $text 置換前の文字列
     * @return string 置換後の文字列
     */
    public static function parseMaskReplacements($text)
    {
        //TODO ニックネームやメールアドレスの承認トークンをデータから置換
        $replacements = [
            self::REPLACEMENT_NICKNAME => 'ニックネーム',
            self::REPLACEMENT_TOKEN => 'qazwsxedcrfvtgb'
        ];

        return strtr($text, $replacements);
    }
}
