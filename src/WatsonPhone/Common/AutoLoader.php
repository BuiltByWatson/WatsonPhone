<?php

namespace WatsonPhone\Common;

/**
 * PSR-0 Autoloader
 */
class AutoLoader
{
    /**
     * @var string $namespace;
     */
    protected $namespace = '';

    // @var string $path;
    protected $path = '';

	
    public function __construct($namespace, $path)
    {
        $this->namespace = ltrim($namespace, '\\');
        $this->path      = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }

    public function load($class)
    {
        $class = ltrim($class, '\\');

        if (strpos($class, $this->namespace) === 0) {
            $nsparts   = explode('\\', $class);
            $class     = array_pop($nsparts);
            $nsparts[] = '';
            $path      = $this->path . implode(DIRECTORY_SEPARATOR, $nsparts);
            $path     .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

            if (file_exists($path)) {
                require $path;

                return true;
            }
        }

        return false;
    }

    public function register()
    {
        return spl_autoload_register(array($this, 'load'));
    }

    public function unregister()
    {
        return spl_autoload_unregister(array($this, 'load'));
    }
}
