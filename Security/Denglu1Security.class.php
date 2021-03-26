<?php

/**
 * @version 1.0
 * 风险控制类
 * @copyright denglu1 tech
 */
class Denglu1Security
{
    /**
     * 登录风险分析
     * @param  string $username 用户名
     * @return bool             风险分析结果
     */
    public static function loginRiskAnalysis($username)
    {
        // 导入
        require_once dirname(__FILE__) . '/Denglu1RiskAnalysisModel_1.class.php';
        // 获取数据
        $result = Denglu1RiskAnalysisModel_1::getRiskAnalysisResult($username);
        // 返回
        return $result;
    }
}
