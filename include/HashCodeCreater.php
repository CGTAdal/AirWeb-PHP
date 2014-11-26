<?php

/**
 * HashCodeCreater class
 *
 * SHA-512によるハッシュコードのを生成する
 */
class HashCodeCreater {
    
    /**
     * 文字列からハッシュ値を生成する
     *
     * @param $merchantID マーチャントID            
     * @param $settlementmethod 決済方法（Null
     *            or 空白→'00'）
     * @param $orderID オーダーID            
     * @param $amount 合計金額            
     * @return ハッシュ値
     */
    public function getHash($merchantID, $settlementmethod, $orderID, $amount){
        $ctx = hash_init('sha512');
        
        $str = AW_MERCHANT_HASH_KEY . "," . $merchantID . "," . ((is_null($settlementmethod) || strlen($settlementmethod) == 0) ? '00' : $settlementmethod) . "," . $orderID . "," . $amount;
        hash_update($ctx, $str);
        $hash = hash_final($ctx, true);
        return $this->bin2hex($hash);
    }
    
    /**
     * バイト型を16進数文字列に変換
     *
     * @param
     *            hash バイナリデータのハッシュ値
     * @return 文字列変換されたハッシュ値
     */
    private function bin2hex($hash){
        return bin2hex($hash);
    }
}

?>