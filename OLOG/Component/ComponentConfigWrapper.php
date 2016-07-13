<?php


namespace OLOG\Component;


class ComponentConfigWrapper
{
    /**
     * @return ComponentConfig
     * @throws \Exception
     */
    public static function getConfigObj()
    {
        $config_obj = \OLOG\ConfWrapper::getRequiredValue(ComponentConstants::MODULE_NAME);
        
        \OLOG\Assert::assert($config_obj instanceof ComponentConfig);

        return $config_obj;
    }
}