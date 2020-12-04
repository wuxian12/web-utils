<?php

declare(strict_types=1);


namespace Wuxian\WebUtils\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * 自定义业务代码规范如下：
 * 错误异常，0……
 * 成功 1
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("success")
     */
    const SUCCESS = 1;
    /**
     * @Message("操作失败")
     */
    const FAIL = 0;
    /**
     * @Message("Internal Server Error!")
     */
    const ERR_SERVER = 5000;

    /**
     * @Message("token无效或过期")
     */
    const TOKEN_AVIAL = 2;

    /**
     * @Message("无权限操作")
     */
    const NO_ACCESS = 3;
}
