<?php

class View
{
    protected $_template = '';
    protected $_data = array();
    protected $_content = '';

    public function __construct(string $viewPath)
    {
        $resourceDir = dirname(__DIR__);
        $this->_template = $resourceDir . '/views/' . trim($viewPath, '/') . '.php';

        if ( ! \is_file($this->_template))
        {
            throw new \RuntimeException('View File Not Exists ("' . $this->_template . '")');
        }
    }

    public function forge(string $viewPath) : self
    {
        return new self($viewPath);
    }

    public function render() : string
    {
        return $this->__toString();
    }

    public function __toString() : string
    {
        \extract($this->_data);

        \ob_start();
        include $this->_template;
        $this->_content = \ob_get_contents();
        \ob_end_clean();

        return $this->_content;
    }

    public function setData($key, $value = null) : self
    {
        if (\is_array($key))
        {
            foreach ($key as $k => $v)
            {
                $this->_data[$k] = $v;
            }
        }
        else
        {
            $this->_data[$key] = $value;
        }

        return $this;
    }
}