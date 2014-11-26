<?php

// 共通インクルードファイル
require_once ('common.php');

/**
 * class CvsForm
 * 入力フォームクラス
 */
class CvsForm extends PurchaseForm {
    
    /**
     * ログクラス
     */
    private $log = null;
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct();
        $this->log = new Logger(__CLASS__);
    }
    
    /**
     * ActionFormのabstruct method
     * エラーチェック
     *
     * @return array() エラーメッセージ（配列）
     */
    public function validate(){
        $log = $this->log->getMethodLog(__METHOD__);
        $errors = array();
        
        return $errors;
    }
}

?>