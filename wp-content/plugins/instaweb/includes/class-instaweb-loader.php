<?php

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Insta Web
 * @subpackage instaweb/includes
 * @author     IQ <contact@iqtsystems.com>
 */
class Instaweb_Loader
{
    /**
     * The array of actions registered with WordPress.
     *
     * @access   protected
     * @var      array $actions The actions registered with WordPress.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @access   protected
     * @var      array $filters The filters registered with WordPress.
     */
    protected $filters;

    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * The array of shortcodes registered with WordPress.
     */
    protected $shortcodes;
    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param    string               $hook             The name of the WordPress action that is triggered.
     * @param    object               $object           The object instance to call the action on.
     * @param    string               $method_name      The name of the method on the object to call.
     * @param    int                  $priority         Optional. The priority at which the function should be fired (default 10).
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the callback.
     * @return   Instaweb_Loader Instance of this class to allow chaining.
     */
    public function add_action($hook, $object, $method_name, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $object, $method_name, $priority, $accepted_args);
        return $this;
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param    string               $hook             The name of the WordPress filter that is triggered.
     * @param    object               $object           The object instance to call the filter on.
     * @param    string               $method_name      The name of the method on the object to call.
     * @param    int                  $priority         Optional. The priority at which the function should be fired (default 10).
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the callback.
     * @return   Instaweb_Loader Instance of this class to allow chaining.
     */
    public function add_filter($hook, $object, $method_name, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $object, $method_name, $priority, $accepted_args);
        return $this;
    }

    /**
     * A helper function that takes the array of hooks and adds the hook to it.
     *
     * @access   private
     * @param    array                $hooks            The array of actions or filters registered with WordPress.
     * @param    string               $hook             The name of the WordPress hook that is triggered.
     * @param    object               $object           The object instance to call the hook on.
     * @param    string               $method_name      The name of the method on the object to call.
     * @param    int                  $priority         Optional. The priority at which the function should be fired (default 10).
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the callback.
     * @return   array The updated array of hooks.
     */
    private function add($hooks, $hook, $object, $method_name, $priority, $accepted_args)
    {

        $hooks[$hook] = array(
            'object'           => $object,
            'method_name'      => $method_name,
            'priority'         => $priority,
            'accepted_args'    => $accepted_args,
        );

        return $hooks;
    }

    /**
     * A utility function that is used to register the shortcodes and hooks into a single
     * collection.
     */
    // private function add_s($shortcodes, $tag, $component, $callback)
    // {

    //     $shortcodes[] = [
    //         'tag' => $tag,
    //         'component' => $component,
    //         'callback' => $callback,
    //     ];

    //     return $shortcodes;
    // }

    /**
     * Register the hooks with WordPress.
     *
     * @access   public
     */
    public function run()
    {

        foreach ($this->filters as $hook => $details) {
            add_filter($hook, array($details['object'], $details['method_name']), $details['priority'], $details['accepted_args']);
        }

        foreach ($this->actions as $hook => $details) {
            add_action($hook, array($details['object'], $details['method_name']), $details['priority'], $details['accepted_args']);
        }

        // foreach ($this->shortcodes as $shortcode) {
        //     extract($shortcode, EXTR_OVERWRITE);
        //     add_shortcode($tag, [$component, $callback]);
        // }
    }
}
