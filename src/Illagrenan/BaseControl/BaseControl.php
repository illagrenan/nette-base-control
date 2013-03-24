<?php

/**
 * Tento soubor je součástí "Nette Base control"
 * @link https://github.com/illagrenan/nette-base-control"
 * 
 * Copyright (c) 2013 Václav Dohnal, http://www.vaclavdohnal.cz
 */


namespace Illagrenan\BaseControl;

use Nette\Application\IPresenter;
use Nette\Application\UI\Control;
use Nette\Templating\ITemplate;
use Nette\Utils\Strings;
use ReflectionObject;

abstract class BaseControl extends Control
{

    /**
     * Koncovka latte šablon
     */
    const LATTE_EXTENSION = ".latte";

    /**
     * Výchozí cesta k šablonám
     */
    const DEFAULT_TEMPLATE_PATH = "templates";

    /**
     * Cesta k šablonám
     * @var string
     */
    private $templatePath;

    /**
     * @param IPresenter $parent
     * @param string $name
     */
    public function __construct(IPresenter $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->templatePath = $this->getAbsolutePathname() . "/" . self::DEFAULT_TEMPLATE_PATH . "/";
    }

    /**
     * @return string
     */
    private function getAbsolutePathname()
    {
        $reflector = new ReflectionObject($this);
        return str_replace($reflector->getShortName() . ".php", "", $reflector->getFileName());
    }

    /**
     * @param string $templatePath
     * @return \Illagrenan\BaseControl\BaseControl
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
        return $this;
    }

    /**
     * Vytvoří šablonu podle zadaného jména
     * @param string $templateName
     * @return ITemplate
     */
    protected function createTemplateFromName($templateName = "default")
    {
        /* @var $template ITemplate */
        $template = $this->createTemplate();

        $templatePath = $this->getTemplatePath($templateName);
        $template->setFile($templatePath);

        return $template;
    }

    /**
     * Vrátí cestu k šabloně
     * @param string $templateName
     * @return string
     */
    protected function getTemplatePath($templateName)
    {
        if (Strings::endsWith($templateName, self::LATTE_EXTENSION) == FALSE)
        {
            $templateName = $templateName . self::LATTE_EXTENSION;
        }

        return $this->templatePath . $templateName;
    }

}
