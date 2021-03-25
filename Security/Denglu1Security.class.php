<?php

class Denglu1Security
{
    public static function loginByTokenRiskAnalysis($username)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1RiskAnalysisModel_1.class.php';
        // 获取数据
        $result = Denglu1RiskAnalysisModel_1::getResult($username);
        // 返回
        return $result;
    }
}
