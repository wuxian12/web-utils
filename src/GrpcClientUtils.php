<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Hyperf\GrpcClient\BaseClient;
use Pb\Params;
use Pb\Reply;
use Wuxian\WebUtils\HyperfUtils;

class GrpcClientUtils extends BaseClient
{
    public function __construct(string $hostname = '', array $options = [
        'credentials' => null,
    ]) {
        parent::__construct($hostname, $options);
    }

    public function curdClient(Params $argument)
    {
        $req = $argument->getRequest();
        !empty($req) ? $argument->setRequest(HyperfUtils::opensslEncrypt($req)) : '';
        list($reply, $status) = $this->_simpleRequest(
            '/pb.client/curdClient',
            $argument,
            [Reply::class, 'decode']
        );
        $data = $reply->getData();
        !empty($data) ? $reply->setData(HyperfUtils::opensslDecrypt($data)) : '';
        return [$reply, $status];
    }
}