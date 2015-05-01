<?php

namespace Routes;

class RouteCompiled
{
    private $regex;

    private $templateParameters;

    public function __construct($regex, array $templateParameters)
    {
        $this->regex = $regex;
        $this->templateParameters = $templateParameters;
    }

    /**
     * @return mixed
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @return array
     */
    public function getTemplateParameters()
    {
        return $this->templateParameters;
    }
}
