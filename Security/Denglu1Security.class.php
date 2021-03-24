<?php

class Denglu1Security
{
    public static function loginByTokenRiskAnalysis($username)
    {
        // 导入
        require_once dirname(__FILE__) . '/../Log/Denglu1Log.class.php';
        require_once dirname(__FILE__) . '/Denglu1RiskAnalysisModel1.class.php';
        // 获取数据
        $data = Denglu1Log::getLogToLoginByTokenRiskAnalysis($username);
        $currentData = $data[0];
        $historyDatas = array_slice($data, 1);
        // 计算风险
        $d2 = 1;
        if (1 <= count($historyDatas)) {
            $d2 = Denglu1RiskAnalysisModel1::calcRisk($currentData, $historyDatas);
        }
        // 根据计算结果给出答案
        if (0.5 > $d2) {
            return false;
        }
        return true;
    }
}
