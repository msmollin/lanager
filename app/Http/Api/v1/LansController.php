<?php namespace Zeropingheroes\Lanager\Http\Api\v1;

use Zeropingheroes\Lanager\Domain\Lans\LanService;
use Zeropingheroes\Lanager\Domain\Lans\LanTransformer;
use Zeropingheroes\Lanager\Http\Api\v1\Traits\FlatResourceTrait;

class LansController extends ResourceServiceController
{

    use FlatResourceTrait;

    /**
     * Set the service and transformer classes
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new LanService;
        $this->transformer = new LanTransformer;
    }

}