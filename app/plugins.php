<?php

class ClassHelper {
	protected static $plugins = array();
	public static function addPlugin($name, array $attrs=array())
	    {
	        $name = ucfirst($name);
	
	        if (isset(self::$plugins[$name])) {
	            // We have already loaded this plugin. Don't try to
	            // do it again with (possibly) different values.
	            // Försten till kvarn får mala.
	            return true;
	        }
	
	        $pluginclass = "{$name}Plugin";
	
	        if (!class_exists($pluginclass)) {
	
	            $files = array("{$pluginclass}.php");
	
	            foreach ($files as $file) {
	                $fullpath = __DIR__.'/plugins/'.$name.'/'.$file;
	                if (@file_exists($fullpath)) {
	                    include_once($fullpath);
	                    break;
	                }
	            }
	            if (!class_exists($pluginclass)) {
					return false;
	            }
	        }
	
	        // Doesn't this $inst risk being garbage collected or something?
	        // TODO: put into a static array that makes sure $inst isn't lost.
	        $inst = new $pluginclass();
	        foreach ($attrs as $aname => $avalue) {
	            $inst->$aname = $avalue;
	        }
	
	        // Record activated plugins for later display/config dump
	        self::$plugins[$name] = $attrs;
	        return true;
	    }

}
?>
<?php


//How to use: Event::handle('OtherAccountProfiles', array($user->getProfile(), &$relMes));

class Event {

    /* Global array of hooks, mapping eventname => array of callables */

    protected static $_handlers = array();

    /**
     * Add an event handler
     * @param string   $name    Name of the event
     * @param callable $handler Code to run
     *
     * @return void
     */

    public static function addHandler($name, $handler) {
        if (array_key_exists($name, Event::$_handlers)) {
            Event::$_handlers[$name][] = $handler;
        } else {
            Event::$_handlers[$name] = array($handler);
        }
    }

    /**
     * Handle an event
     *
     * Events are any point in the code that we want to expose for admins
     * or third-party developers to use.
     *
     * We pass in an array of arguments (including references, for stuff
     * that can be changed), and each assigned handler gets run with those
     * arguments. Exceptions can be thrown to indicate an error.
     *
     * @param string $name Name of the event that's happening
     * @param array  $args Arguments for handlers
     *
     * @return boolean flag saying whether to continue processing, based
     *                 on results of handlers.
     */

    public static function handle($name, array $args=array()) {
        $result = null;
        if (array_key_exists($name, Event::$_handlers)) {
            foreach (Event::$_handlers[$name] as $handler) {
                $result = call_user_func_array($handler, $args);
                if ($result === false) {
                    break;
                }
            }
        }
        return ($result !== false);
    }

    /**
     * Check to see if an event handler exists
     *
     * Look to see if there's any handler for a given event, or narrow
     * by providing the name of a specific plugin class.
     *
     * @param string $name Name of the event to look for
     * @param string $plugin Optional name of the plugin class to look for
     *
     * @return boolean flag saying whether such a handler exists
     *
     */

    public static function hasHandler($name, $plugin=null) {
        if (array_key_exists($name, Event::$_handlers)) {
            if (isset($plugin)) {
                foreach (Event::$_handlers[$name] as $handler) {
                    if (get_class($handler[0]) == $plugin) {
                        return true;
                    }
                }
            } else {
                return true;
            }
        }
        return false;
    }

    public static function getHandlers($name)
    {
        return Event::$_handlers[$name];
    }

    /**
     * Disables any and all handlers that have been set up so far;
     * use only if you know it's safe to reinitialize all plugins.
     */
    public static function clearHandlers() {
        Event::$_handlers = array();
    }
}
?>
<?php
//Stupid simple aint it?
class Plugin
{
    function __construct()
    {
		//Default Events
        Event::addHandler('InitializePlugin', array($this, 'initialize'));
        foreach (get_class_methods($this) as $method) {
            if (mb_substr($method, 0, 2) == 'on') {
                Event::addHandler(mb_substr($method, 2), array($this, $method));
            }
        }

    }

    function initialize()
    {
        return true;
    }
}
?>